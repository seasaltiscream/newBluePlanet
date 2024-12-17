<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\volunteerForm;
use Alert;

class HomeController extends Controller
{
    // Redirects users to the appropriate home page based on their user type (user or admin)
    public function index()
    {
        if (Auth::id()) {
            $post=Post::where('post_status', '=', 'active')->get();
            $userType = Auth()->user()->userType;  // Get the user type from the authenticated user

            // If user type is 'user', redirect to user home page
            if ($userType == 'user') {
                // return view('home.homePage');
                return $this->homePage();
            }
            // If user type is 'admin', redirect to admin home page
            elseif ($userType == 'admin') {
                return redirect('/adminhome');  // Ensure this points to the correct admin route
            } else {
                return redirect()->back();  // Redirect back if no user type is found
            }
        }
    }

    //     public function index()
    // {
    //     if (!Auth::check()) {
    //         return redirect('/login')->with('error', 'You need to log in first.'); // Redirect unauthenticated users to login
    //     }

    //     $userType = Auth::user()->userType; // Get the user type of the authenticated user

    //     if ($userType === 'user') {
    //         return view('home.homePage');
    //     } elseif ($userType === 'admin') {
    //         return redirect('/adminhome');
    //     }

    //     return redirect()->back(); // Fallback if userType is undefined
    // }


    // Fetch the latest 3 posts and forms with 'active' status and pass them to the view
    public function homePage()
    {
        $posts = Post::where('post_status', 'active')
                    ->latest()  // Get the most recent posts
                    ->take(3)  // Limit to 3 posts
                    ->get();

        $forms = volunteerForm::where('status', 'active')
                            ->latest()  // Get the most recent forms
                            ->take(3)  // Limit to 3 forms
                            ->get();

        // Pass the posts and forms to the view
        return view('home.homePage', compact('posts', 'forms'));
    }

    // Display details of a single post based on its ID
    public function post_details($id)
    {
        $post = Post::find($id);  // Find the post by ID
        return view('home.post_details', compact('post'));
    }

    // Render the page to create a new post
    public function create_post()
    {
        return view('home.create_post');
    }

    // Handle the creation of a new post by saving it in the database
    public function user_post(Request $request)
    {
        $user = Auth()->user();  // Get the authenticated user
        $userid = $user->id;
        $username = $user->name;
        $userType = $user->userType;

        // Create a new post instance
        $post = new Post;
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = $userid;
        $post->name = $username;
        $post->userType = $userType;
        $post->post_status = 'pending';  // Set the post status as pending initially

        // Handle image upload
        $image = $request->image;
        if ($image) {
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('postimage', $imagename);  // Move the image to the postimage folder
            $post->image = $imagename;
        }

        // Handle video link (YouTube URL)
        $videoLink = $request->video_link;
        if ($videoLink) {
            $post->video_link = $videoLink;

            // Fetch YouTube thumbnail based on the video ID from the URL
            $videoId = $this->extractYoutubeId($videoLink);
            if ($videoId) {
                $post->thumbnail = "https://img.youtube.com/vi/$videoId/0.jpg";  // Use YouTube's default thumbnail
            }
        }

        $post->save();  // Save the post to the database

        Alert::success('Success', 'Data added successfully');  // Show success alert
        return redirect()->back();  // Redirect back to the previous page
    }

    // Fetch and display posts created by the authenticated user
    public function my_post()
    {
        $user = Auth()->user();  // Get the authenticated user
        $userid = $user->id;
        $data = Post::where('user_id', '=', $userid)->get();  // Get posts by the user
        return view('home.my_post', compact('data'));
    }

    // Delete a specific post by its ID
    public function deleteUserPost($id)
    {
        $data = Post::find($id);
        $data->delete();  // Delete the post
        return redirect()->back()->with('message', 'Post deleted successfully');
    }

    // Render the page to update an existing post
    public function update_user_post($id)
    {
        $data = Post::find($id);  // Find the post by ID
        return view('home.post_page', compact('data'));
    }

    // Extract YouTube video ID from a URL
    private function extractYoutubeId($url)
    {
        preg_match("/(?:https?:\/\/(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+|(?:v|e(?:mbed)?)\/|\S+\?v=)|youtu\.be\/))([\w\-]{11})/", $url, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }

    // Update post data (e.g., title, description, image, video, and thumbnail)
    public function update_postData(Request $request, $id)
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
    // Use YouTube thumbnail only if there's no image
    $post->thumbnail = $youtube_id
        ? "https://img.youtube.com/vi/{$youtube_id}/hqdefault.jpg"
        : ($post->image ?? 'default_thumbnail.jpg');
} else {
    // Retain the original image thumbnail or use default if no image
    $post->thumbnail = $post->image ? '/postimage/' . $post->image : 'default_thumbnail.jpg';
}


        $post->save();
        return redirect()->back()->with('message', 'Post Updated Successfully!');
    }

public function deleteYoutubeLink($id)
{
    $post = Post::find($id);

    if ($post) {
        // Remove YouTube link and reset thumbnail
        $post->video_link = null;
        $post->thumbnail = null;  // Optionally reset the thumbnail
        $post->save();

        return redirect()->back()->with('message', 'YouTube link deleted successfully.');
    }

    return redirect()->back()->with('error', 'Post not found.');
}


    // About Us page
    public function about_us()
    {
        return view('home.about_us');
    }

    // Fetch and display all active blog posts
    public function blog_posts()
    {
        $posts = Post::where('post_status', '=', 'active')->get();  // Get all active posts
        return view('home.blog_posts', compact('posts'));  // Pass posts to the view
    }

    // Fetch and display all active volunteer posts
    public function volunteer_posts()
    {
        $forms = volunteerForm::where('status', '=', 'active')->get();  // Get all active forms
        return view('home.volunteer_posts', compact('forms'));  // Pass forms to the view
    }

    // Create a new volunteer form
    public function create_form()
    {
        return view('home.create_form');
    }

    // Fetch and display all forms created by the authenticated user
    public function my_form()
    {
        $user = Auth()->user();  // Get the authenticated user
        $userid = $user->id;
        $forms = volunteerForm::where('user_id', '=', $userid)->get();  // Get forms by the user
        return view('home.my_form', compact('forms'));  // Pass forms to the view
    }

    // Handle the creation of a new volunteer form
    public function user_form(Request $request)
    {
        $user = Auth()->user();
        $userid = $user->id;
        $username = $user->name;
        $userType = $user->userType;

        // Create a new volunteer form instance
        $forms = new volunteerForm;
        $forms->name = $request->title;
        $forms->description = $request->description;
        $forms->link = $request->link;
        $forms->creator = $username;
        $forms->user_id = $userid;
        $forms->status = 'pending';  // Default status as 'pending'

        // Handle image upload for the form
        $image = $request->file('image');
        if ($image) {
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('formImage'), $imagename);  // Store image in public/form_images
            $forms->image = $imagename;  // Update the image field
        }
        else {
            $forms->image = 'defaultForm.png';  // Default image if none is uploaded
        }

        $forms->save();  // Save the form to the database

        Alert::success('Success', 'Volunteer form added successfully');
        return redirect()->back();  // Redirect back to the form creation page
    }

    // Delete a volunteer form by its ID
    public function deleteForm($id)
    {
        $forms = volunteerForm::find($id);
        $forms->delete();  // Delete the form
        return redirect()->back()->with('message', 'Form deleted successfully');
    }

    // Render the page to update an existing volunteer form
    public function update_user_form($id)
    {
        $forms = volunteerForm::find($id);  // Find the form by ID
        return view('home.form_page', compact('forms'));  // Return the form page with the form data
    }

    // Update volunteer form data (title, description, image)
    public function update_formData(Request $request, $id)
    {
        $forms = volunteerForm::find($id);

        $forms->name = $request->title;
        $forms->description = $request->description;
        $forms->link = $request->link;

        // Handle image upload for the form (if new image is uploaded)
        $image = $request->file('image');
        if ($image) {
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('formImage'), $imagename);  // Store image in public/form_images
            $forms->image = $imagename;
        }

        $forms->save();  // Save the updated form data

        return redirect()->back()->with('message', 'Form updated successfully');
    }

// public function resetThumb($id)
// {
//     $post = Post::find($id);

//     if ($post && $post->video_link) {
//         // Extract YouTube video ID
//         $videoId = $this->extractYoutubeId($post->video_link);
//         if ($videoId) {
//             // Set the YouTube thumbnail
//             $post->thumbnail = "https://img.youtube.com/vi/$videoId/0.jpg";

//             // Save the updated thumbnail
//             $post->save();

//             return redirect()->back()->with('message', 'Thumbnail reset to YouTube thumbnail successfully.');
//         }
//     }

//     return redirect()->back()->with('error', 'Unable to reset thumbnail. Ensure a valid YouTube link exists.');
// }

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

        private function getYouTubeVideoId($url)
    {
        preg_match("/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/", $url, $matches);
        return $matches[1] ?? null;
    }

}
