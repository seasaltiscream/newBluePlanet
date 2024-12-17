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

        // Update basic information
        $user->fill($request->validated());

        // Reset email verification if email changes
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $this->handleProfilePhotoUpload($request, $user);
        }

        // Handle password update if provided
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display user profile.
     */
    public function user_profile()
    {
        $user = Auth::user();
        return view('home.user_profile', compact('user'));
    }

    /**
     * Display user edit profile form.
     */
    public function edit_profile()
    {
        $user = Auth::user();
        return view('home.edit_profile', compact('user'));
    }

    /**
     * Update user profile.
     */
    public function update_profile(Request $request)
    {
        $user = Auth::user();

        // Update basic fields
        $user->name = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Handle password update
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $this->handleProfilePhotoUpload($request, $user);
        }

        $user->save();

        return redirect('/user_profile')->with('message', 'Profile updated successfully!');
    }

    /**
     * Display admin profile.
     */
    public function admin_profile()
    {
        $user = Auth::user();

        // Ensure the user is an admin
        if ($user->userType !== 'admin') {
            return redirect('/homePage')->with('error', 'Access Denied!');
        }

        return view('admin.admin_profile', compact('user'));
    }

    /**
     * Display admin edit profile form.
     */
    public function edit_admin()
    {
        $user = Auth::user();

        // Ensure the user is an admin
        if ($user->userType !== 'admin') {
            return redirect('/homePage')->with('error', 'Access Denied!');
        }

        return view('admin.edit_admin', compact('user')); // Ensure this points to the correct view
    }

    /**
     * Update admin profile.
     */
    public function updateAdmin(Request $request)
    {
        $user = Auth::user();

        // Update basic fields
        $user->name = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Handle password update
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $this->handleProfilePhotoUpload($request, $user);
        }

        $user->save();

        return redirect(url('/admin_profile'))->with('message', 'Profile updated successfully!');
    }

    /**
     * Assign a default profile picture when a user is registered.
     */
/**
 * Assign a default profile picture when a user is registered.
 */
    public function assignDefaultProfilePicture($user)
    {
        // Define default profile image
        $defaultProfile = 'defaultProfile.png';

        // Define folder based on user type
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
            // Set the profile photo path
            $user->profile_photo_path = $newPath;
            $user->save();
        }
    }


    /**
     * Handle profile photo upload.
     */
    // private function handleProfilePhotoUpload(Request $request, $user)
    // {
    //     // Define folder based on user type
    //     $folder = $user->userType === 'admin' ? 'profileAdmin' : 'profileUser';

    //     // Ensure the directory exists
    //     // $destinationPath = public_path($folder);
    //     $destinationPath = storage_path('public/' . $folder);
    //     if (!file_exists($destinationPath)) {
    //         mkdir($destinationPath, 0755, true);
    //     }

    //     // Generate unique file name
    //     $fileName = time() . '_' . $request->file('profile_photo')->getClientOriginalName();

    //     // Move the uploaded file to the user's folder
    //     $request->file('profile_photo')->move($destinationPath, $fileName);

    //     // Update the profile photo path in the database
    //     // $user->profile_photo_path = "$folder/$fileName";
    //     // $user->profile_photo_path = $folder . '/' . $fileName;
    //     $user->profile_photo_path = 'public/' . $folder . '/' . $fileName;

    // }

    private function handleProfilePhotoUpload(Request $request, $user)
    {
        // Define folder based on user type
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



    // private function handleProfilePhotoUpload(Request $request, $user)
    // {
    //     // Define folder based on user type
    //     $folder = $user->userType === 'admin' ? 'profileAdmin' : 'profileUser';

    //     // Store the uploaded file in the defined folder
    //     $fileName = time() . '_' . $request->file('profile_photo')->getClientOriginalName();
    //     $path = $request->file('profile_photo')->storeAs('public/' . $folder, $fileName);

    //     // Update the profile photo path in the database
    //     $user->profile_photo_path = 'storage/' . $folder . '/' . $fileName;
    // }


}
