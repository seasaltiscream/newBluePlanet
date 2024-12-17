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
                'user' => view('home.homePage'),
                'admin' => view('admin.adminhome'),
                default => redirect()->back(),
            };
        }

        return redirect()->route('login'); // Redirect to login if not authenticated
    }

    // Admin home showing latest posts and forms
    public function adminhome()
    {
        $filteredPosts = Post::whereIn('post_status', ['pending', 'active'])
            ->latest()
            ->take(3)
            ->get();

        $filteredForms = VolunteerForm::whereIn('status', ['pending', 'active'])
            ->latest()
            ->take(3)
            ->get();

        return view('admin.adminhome', compact('filteredPosts', 'filteredForms'));
    }

    // Display the post creation page
    public function post_page()
    {
        return view('admin.post_page');
    }

    // Add a new post
    public function add_post(Request $request)
    {
        $user = Auth::user();

        $post = new Post;
        $post->title = $request->title;
        $post->description = $request->description;
        $post->post_status = 'active';
        $post->user_id = $user->id;
        $post->name = $user->name;
        $post->userType = $user->userType;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagename = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('postimage'), $imagename);
            $post->image = $imagename;
        }

        // Handle YouTube video link and thumbnail
        if ($request->video_link) {
            $post->video_link = $request->video_link;

            $youtube_id = $this->getYouTubeVideoId($request->video_link);
            $post->thumbnail = $youtube_id
                ? "https://img.youtube.com/vi/{$youtube_id}/hqdefault.jpg"
                : 'default_video_thumbnail.jpg';
        }

        // Set default thumbnail if none is provided
        $post->thumbnail ??= 'default_thumbnail.jpg';

        $post->save();
        return redirect()->back()->with('message', 'Post Added Successfully!');
    }

    // Display all posts
    public function show_post()
    {
        $posts = Post::all();
        return view('admin.show_post', compact('posts'));
    }

    // Delete a post
    public function delete_post($id)
    {
        $post = Post::findOrFail($id);

        // Delete associated image if exists
        if ($post->image && file_exists(public_path('postimage/' . $post->image))) {
            unlink(public_path('postimage/' . $post->image));
        }

        $post->delete();
        return redirect()->back()->with('message', 'Post Deleted Successfully');
    }

    // Edit post page
    public function edit_post($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.edit_page', compact('post'));
    }

    // Update post
    public function update_post(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->title = $request->title;
        $post->description = $request->description;

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path('postimage/' . $post->image))) {
                unlink(public_path('postimage/' . $post->image));
            }
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('postimage'), $imageName);
            $post->image = $imageName;
        }

        // Handle video link
        if ($request->video_link) {
            $post->video_link = $request->video_link;

            $youtube_id = $this->getYouTubeVideoId($request->video_link);
            $post->thumbnail = $youtube_id
                ? "https://img.youtube.com/vi/{$youtube_id}/hqdefault.jpg"
                : ($post->image ?? 'default_thumbnail.jpg');
        }

        $post->save();
        return redirect()->back()->with('message', 'Post Updated Successfully!');
    }

    // Accept post
    public function accept_post($id)
    {
        $post = Post::findOrFail($id);
        $post->post_status = 'active';
        $post->save();

        return redirect()->back()->with('message', 'Post Status Changed to Active');
    }

    // Reject post
    public function reject_post($id)
    {
        $post = Post::findOrFail($id);
        $post->post_status = 'rejected';
        $post->save();

        return redirect()->back()->with('message', 'Post Status Changed to Rejected');
    }

    // Reset post thumbnail to YouTube thumbnail or default
    public function resetThumb($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image && file_exists(public_path('postimage/' . $post->image))) {
            unlink(public_path('postimage/' . $post->image));
        }

        $post->thumbnail = $post->video_link
            ? "https://img.youtube.com/vi/" . $this->getYouTubeVideoId($post->video_link) . "/hqdefault.jpg"
            : 'default_thumbnail.jpg';

        $post->save();
        return redirect()->back()->with('message', 'Thumbnail Reset Successfully');
    }

    // Extract YouTube video ID
    private function getYouTubeVideoId($url)
    {
        preg_match("/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/", $url, $matches);
        return $matches[1] ?? null;
    }

    // Volunteer form methods
    public function form_page()
    {
        return view('admin.form_page');
    }

    public function add_form(Request $request)
    {
        $form = new VolunteerForm;
        $form->name = $request->name;
        $form->description = $request->description;
        $form->link = $request->link;
        $form->status = 'active';
        $form->creator = Auth::user()->name;

        if ($request->hasFile('image')) {
            $imagename = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('formImage'), $imagename);
            $form->image = $imagename;
        } else {
            $form->image = 'defaultForm.png';
        }

        $form->save();
        return redirect()->back()->with('message', 'Form Added Successfully!');
    }

    public function show_form()
    {
        $forms = VolunteerForm::all();
        return view('admin.show_form', compact('forms'));
    }

    public function delete_form($id)
    {
        $form = VolunteerForm::findOrFail($id);

        if ($form->image && file_exists(public_path('formImage/' . $form->image))) {
            unlink(public_path('formImage/' . $form->image));
        }

        $form->delete();
        return redirect()->back()->with('message', 'Form Deleted Successfully');
    }

    public function edit_form_page($id)
    {
        $form = VolunteerForm::findOrFail($id);
        return view('admin.edit_form_page', compact('form'));
    }

    public function update_form(Request $request, $id)
{
    $form = VolunteerForm::findOrFail($id);

    $form->name = $request->name;
    $form->description = $request->description;
    $form->link = $request->link;

    // Handle image upload
    if ($request->hasFile('image')) {
        // Only delete the image if it's not the default image
        if ($form->image !== 'defaultForm.png' && file_exists(public_path('formImage/' . $form->image))) {
            unlink(public_path('formImage/' . $form->image));
        }

        $imageName = time() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('formImage'), $imageName);
        $form->image = $imageName;
    }

    $form->save();
    return redirect()->back()->with('message', 'Form Updated Successfully!');
}


    public function accept_form($id)
    {
        $form = VolunteerForm::findOrFail($id);
        $form->status = 'active';
        $form->save();

        return redirect()->back()->with('message', 'Form Accepted Successfully!');
    }

    public function reject_form($id)
    {
        $form = VolunteerForm::findOrFail($id);
        $form->status = 'rejected';
        $form->save();

        return redirect()->back()->with('message', 'Form Rejected Successfully!');
    }

public function resetFormImage($id)
{
    $form = VolunteerForm::findOrFail($id);

    // Only delete the image if it's not the default one
    if ($form->image !== 'defaultForm.png' && file_exists(public_path('formImage/' . $form->image))) {
        unlink(public_path('formImage/' . $form->image));
    }

    // Set the image to the default image
    $form->image = 'defaultForm.png';
    $form->save();

    return redirect()->back()->with('message', 'Form Image Reset to Default');
}




}
