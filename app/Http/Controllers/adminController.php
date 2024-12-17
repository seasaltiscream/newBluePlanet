<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\VolunteerForm;

class adminController extends Controller
{
    // Redirect users based on their user type
    public function index()
    {
        if (Auth::check()) {
            $userType = Auth::user()->userType;

            return match ($userType) {
                'user' => view('home.homePage'),  // Redirect to user home page
                'admin' => view('admin.adminhome'), // Redirect to admin home page
                default => redirect()->back(),  // Redirect back if user type is not recognized
            };
        }

        return redirect()->route('login'); // Redirect to login if not authenticated
    }

    // Admin home showing latest posts and forms
    public function adminhome()
    {
        $filteredPosts = Post::whereIn('post_status', ['pending', 'active']) // Get posts that are pending or active
            ->latest()  // Get the latest posts
            ->take(3)  // Limit to the latest 3 posts
            ->get();

        $filteredForms = VolunteerForm::whereIn('status', ['pending', 'active']) // Get forms that are pending or active
            ->latest()  // Get the latest forms
            ->take(3)  // Limit to the latest 3 forms
            ->get();

        return view('admin.adminhome', compact('filteredPosts', 'filteredForms'));  // Pass posts and forms to the view
    }

    // Display the post creation page
    public function post_page()
    {
        return view('admin.post_page');  // Return the post creation view
    }

    // Add a new post
    public function add_post(Request $request)
    {
        $user = Auth::user();  // Get the current authenticated user

        $post = new Post;
        $post->title = $request->title;  // Set the post title
        $post->description = $request->description;  // Set the post description
        $post->post_status = 'active';  // Set post status to active
        $post->user_id = $user->id;  // Set the user ID
        $post->name = $user->name;  // Set the user name
        $post->userType = $user->userType;  // Set the user type

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagename = time() . '.' . $request->image->getClientOriginalExtension();  // Generate unique image name
            $request->image->move(public_path('postimage'), $imagename);  // Move image to postimage folder
            $post->image = $imagename;  // Set the post image
        }

        // Handle YouTube video link and thumbnail
        if ($request->video_link) {
            $post->video_link = $request->video_link;

            $youtube_id = $this->getYouTubeVideoId($request->video_link);  // Extract YouTube video ID
            $post->thumbnail = $youtube_id
                ? "https://img.youtube.com/vi/{$youtube_id}/hqdefault.jpg"  // Use YouTube thumbnail if video ID is found
                : 'default_video_thumbnail.jpg';  // Use default thumbnail if no video ID
        }

        // Set default thumbnail if none is provided
        $post->thumbnail ??= 'default_thumbnail.jpg';  // Set default thumbnail if not set

        $post->save();  // Save the post
        return redirect()->back()->with('message', 'Post Added Successfully!');  // Redirect with success message
    }

    // Display all posts
    public function show_post()
    {
        $posts = Post::all();  // Get all posts
        return view('admin.show_post', compact('posts'));  // Pass posts to the view
    }

    // Delete a post
    public function delete_post($id)
    {
        $post = Post::findOrFail($id);  // Find the post by ID

        // Delete associated image if exists
        if ($post->image && file_exists(public_path('postimage/' . $post->image))) {
            unlink(public_path('postimage/' . $post->image));  // Delete image from server
        }

        $post->delete();  // Delete the post
        return redirect()->back()->with('message', 'Post Deleted Successfully');  // Redirect with success message
    }

    // Edit post page
    public function edit_post($id)
    {
        $post = Post::findOrFail($id);  // Find the post by ID
        return view('admin.edit_page', compact('post'));  // Return the edit post page with post data
    }

    // Update post
    public function update_post(Request $request, $id)
    {
        $post = Post::findOrFail($id);  // Find the post by ID

        $post->title = $request->title;  // Update the post title
        $post->description = $request->description;  // Update the post description

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($post->image && file_exists(public_path('postimage/' . $post->image))) {
                unlink(public_path('postimage/' . $post->image));  // Delete the old image
            }
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();  // Generate unique image name
            $request->image->move(public_path('postimage'), $imageName);  // Move new image to the server
            $post->image = $imageName;  // Set the new image
        }

        // Handle video link
        if ($request->video_link) {
            $post->video_link = $request->video_link;

            $youtube_id = $this->getYouTubeVideoId($request->video_link);  // Extract YouTube video ID
            $post->thumbnail = $youtube_id
                ? "https://img.youtube.com/vi/{$youtube_id}/hqdefault.jpg"  // Use YouTube thumbnail if video ID is found
                : ($post->image ?? 'default_thumbnail.jpg');  // Use existing image or default thumbnail
        }

        $post->save();  // Save the updated post
        return redirect()->back()->with('message', 'Post Updated Successfully!');  // Redirect with success message
    }

    // Accept post
    public function accept_post($id)
    {
        $post = Post::findOrFail($id);  // Find the post by ID
        $post->post_status = 'active';  // Change the post status to active
        $post->save();  // Save the updated post

        return redirect()->back()->with('message', 'Post Status Changed to Active');  // Redirect with success message
    }

    // Reject post
    public function reject_post($id)
    {
        $post = Post::findOrFail($id);  // Find the post by ID
        $post->post_status = 'rejected';  // Change the post status to rejected
        $post->save();  // Save the updated post

        return redirect()->back()->with('message', 'Post Status Changed to Rejected');  // Redirect with success message
    }

    // Reset post thumbnail to YouTube thumbnail or default
    public function resetThumb($id)
    {
        $post = Post::findOrFail($id);  // Find the post by ID

        // Delete the image if it exists
        if ($post->image && file_exists(public_path('postimage/' . $post->image))) {
            unlink(public_path('postimage/' . $post->image));  // Delete the image
        }

        // Set thumbnail to YouTube thumbnail or default
        $post->thumbnail = $post->video_link
            ? "https://img.youtube.com/vi/" . $this->getYouTubeVideoId($post->video_link) . "/hqdefault.jpg"
            : 'default_thumbnail.jpg';  // Use YouTube thumbnail if video link exists, otherwise set default thumbnail

        $post->save();  // Save the updated post
        return redirect()->back()->with('message', 'Thumbnail Reset Successfully');  // Redirect with success message
    }

    // Extract YouTube video ID
    private function getYouTubeVideoId($url)
    {
        preg_match("/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/", $url, $matches);
        return $matches[1] ?? null;  // Extract and return the YouTube video ID
    }

    // Volunteer form methods
    public function form_page()
    {
        return view('admin.form_page');  // Return the form creation page view
    }

    public function add_form(Request $request)
    {
        $form = new VolunteerForm;
        $form->name = $request->name;  // Set the form name
        $form->description = $request->description;  // Set the form description
        $form->link = $request->link;  // Set the form link
        $form->status = 'active';  // Set form status to active
        $form->creator = Auth::user()->name;  // Set the form creator

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagename = time() . '.' . $request->image->getClientOriginalExtension();  // Generate unique image name
            $request->image->move(public_path('formImage'), $imagename);  // Move image to formImage folder
            $form->image = $imagename;  // Set the form image
        } else {
            $form->image = 'defaultForm.png';  // Set default form image if none is uploaded
        }

        $form->save();  // Save the form
        return redirect()->back()->with('message', 'Form Added Successfully!');  // Redirect with success message
    }

    public function show_form()
    {
        $forms = VolunteerForm::all();  // Get all forms
        return view('admin.show_form', compact('forms'));  // Pass forms to the view
    }

    public function delete_form($id)
    {
        $form = VolunteerForm::findOrFail($id);  // Find the form by ID

        // Delete associated image if exists
        if ($form->image && file_exists(public_path('formImage/' . $form->image))) {
            unlink(public_path('formImage/' . $form->image));  // Delete image from server
        }

        $form->delete();  // Delete the form
        return redirect()->back()->with('message', 'Form Deleted Successfully');  // Redirect with success message
    }

    public function edit_form_page($id)
    {
        $form = VolunteerForm::findOrFail($id);  // Find the form by ID
        return view('admin.edit_form_page', compact('form'));  // Return the edit form page with form data
    }

    public function update_form(Request $request, $id)
    {
        $form = VolunteerForm::findOrFail($id);  // Find the form by ID

        $form->name = $request->name;  // Update form name
        $form->description = $request->description;  // Update form description
        $form->link = $request->link;  // Update form link

        // Handle image upload
        if ($request->hasFile('image')) {
            // Only delete the image if it's not the default image
            if ($form->image !== 'defaultForm.png' && file_exists(public_path('formImage/' . $form->image))) {
                unlink(public_path('formImage/' . $form->image));  // Delete old image
            }

            $imageName = time() . '.' . $request->image->getClientOriginalExtension();  // Generate unique image name
            $request->image->move(public_path('formImage'), $imageName);  // Move new image to formImage folder
            $form->image = $imageName;  // Set the new image
        }

        $form->save();  // Save the updated form
        return redirect()->back()->with('message', 'Form Updated Successfully!');  // Redirect with success message
    }

    public function accept_form($id)
    {
        $form = VolunteerForm::findOrFail($id);  // Find the form by ID
        $form->status = 'active';  // Set form status to active
        $form->save();  // Save the updated form

        return redirect()->back()->with('message', 'Form Accepted Successfully!');  // Redirect with success message
    }

    public function reject_form($id)
    {
        $form = VolunteerForm::findOrFail($id);  // Find the form by ID
        $form->status = 'rejected';  // Set form status to rejected
        $form->save();  // Save the updated form

        return redirect()->back()->with('message', 'Form Rejected Successfully!');  // Redirect with success message
    }

    public function resetFormImage($id)
    {
        $form = VolunteerForm::findOrFail($id);  // Find the form by ID

        // Only delete the image if it's not the default one
        if ($form->image !== 'defaultForm.png' && file_exists(public_path('formImage/' . $form->image))) {
            unlink(public_path('formImage/' . $form->image));  // Delete the old image
        }

        // Set the image to the default image
        $form->image = 'defaultForm.png';  // Set default image for the form
        $form->save();  // Save the updated form

        return redirect()->back()->with('message', 'Form Image Reset to Default');  // Redirect with success message
    }
}
