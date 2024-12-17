<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        // Return the profile edit view with the user data
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Update basic user information using validated request data
        $user->fill($request->validated());

        // Reset email verification if the email has changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle profile photo upload if a file is provided
        if ($request->hasFile('profile_photo')) {
            $this->handleProfilePhotoUpload($request, $user);
        }

        // Handle password update if the password is provided
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Save the updated user information
        $user->save();

        // Redirect back with success message
        return Redirect::route('profile.edit')->with('status', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validate password before allowing account deletion
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Logout the user
        Auth::logout();

        // Delete the user account
        $user->delete();

        // Invalidate and regenerate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the homepage after account deletion
        return Redirect::to('/');
    }

    /**
     * Display user profile.
     */
    public function user_profile()
    {
        // Get the authenticated user and return the user profile view
        $user = Auth::user();
        return view('home.user_profile', compact('user'));
    }

    /**
     * Display user edit profile form.
     */
    public function edit_profile()
    {
        // Get the authenticated user and return the edit profile view
        $user = Auth::user();
        return view('home.edit_profile', compact('user'));
    }

    /**
     * Update user profile.
     */
    public function update_profile(Request $request)
    {
        $user = Auth::user();

        // Update basic fields with data from the request
        $user->name = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Handle password update if provided
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile photo upload if a file is provided
        if ($request->hasFile('profile_photo')) {
            $this->handleProfilePhotoUpload($request, $user);
        }

        // Save the updated user information
        $user->save();

        // Redirect to the user profile page with a success message
        return redirect('/user_profile')->with('message', 'Profile updated successfully!');
    }

    /**
     * Display admin profile.
     */
    public function admin_profile()
    {
        $user = Auth::user();

        // Ensure the authenticated user is an admin
        if ($user->userType !== 'admin') {
            return redirect('/homePage')->with('error', 'Access Denied!');
        }

        // Return the admin profile view
        return view('admin.admin_profile', compact('user'));
    }

    /**
     * Display admin edit profile form.
     */
    public function edit_admin()
    {
        $user = Auth::user();

        // Ensure the authenticated user is an admin
        if ($user->userType !== 'admin') {
            return redirect('/homePage')->with('error', 'Access Denied!');
        }

        // Return the admin edit profile view
        return view('admin.edit_admin', compact('user'));
    }

    /**
     * Update admin profile.
     */
    public function updateAdmin(Request $request)
    {
        $user = Auth::user();

        // Update basic fields with data from the request
        $user->name = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Handle password update if provided
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile photo upload if a file is provided
        if ($request->hasFile('profile_photo')) {
            $this->handleProfilePhotoUpload($request, $user);
        }

        // Save the updated user information
        $user->save();

        // Redirect to the admin profile page with a success message
        return redirect(url('/admin_profile'))->with('message', 'Profile updated successfully!');
    }

    /**
     * Assign a default profile picture when a user is registered.
     */
    public function assignDefaultProfilePicture($user)
    {
        // Define default profile image
        $defaultProfile = 'defaultProfile.png';

        // Define folder based on user type (admin or user)
        $folder = $user->userType === 'admin' 
            ? 'profileAdmin' 
            : 'profileUser'; 

        // Ensure the directory exists
        $destinationPath = public_path($folder);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);  // Create directory if it doesn't exist
        }

        // Check if the default profile image exists in the public folder
        $defaultPath = public_path($defaultProfile);
        if (file_exists($defaultPath)) {
            $newPath = "$folder/$defaultProfile";
            // Copy the default profile picture into the user's folder
            copy($defaultPath, public_path($newPath));
            // Set the profile photo path in the database
            $user->profile_photo_path = $newPath;
            $user->save();
        }
    }

    /**
     * Handle profile photo upload.
     */
    private function handleProfilePhotoUpload(Request $request, $user)
    {
        // Define folder based on user type (admin or user)
        $folder = $user->userType === 'admin' ? 'profileAdmin' : 'profileUser';

        // Define the path where the file will be stored in the public directory
        $destinationPath = public_path($folder);

        // Ensure the folder exists
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Generate a unique file name
        $fileName = time() . '_' . $request->file('profile_photo')->getClientOriginalName();

        // Move the uploaded file to the public directory
        $request->file('profile_photo')->move($destinationPath, $fileName);

        // Update the profile photo path in the database
        $user->profile_photo_path = $folder . '/' . $fileName;
    }
}
