<!DOCTYPE html>
<html>
<head>
    <base href="/public">
    @include('admin.css') <!-- Includes the external CSS file for admin styles -->

    <style type="text/css">
        /* Styling for the post title */
        .post_title {
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            padding: 30px;
            color: white;
        }

        /* Centering the content inside a container */
        .div_center {
            text-align: center;
            padding: 30px;
        }

        /* Styling for form labels */
        label {
            font-size: 20px;
            font-weight: bold;
            color: white;
            width: 200px;
            display: inline-block;
        }

        /* Styling for input fields and text areas */
        .input_design {
            padding: 20px;
        }

        /* Styling for the image preview */
        .img_adjustment {
            max-width: 100%;
            max-height: 400px;
            width: auto;
            height: auto;
            display: block;
            margin: auto;
        }

        /* Styling for the submit button */
        .submitBtn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        /* Hover effect for the submit button */
        .submitBtn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    @include('admin.header') <!-- Include the header for the admin page -->
    <div class="d-flex align-items-stretch">
        <!-- Sidebar Navigation -->
        @include('admin.sidebar') <!-- Include the sidebar for the admin page -->
        <!-- Sidebar Navigation end -->

        <div class="page-content">
            <!-- Display success message after form submission -->
            @if(session()->has('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                    {{ session()->get('message') }}
                </div>
            @endif

            <!-- Title of the post edit page -->
            <h1 class="post_title">Edit Post {{ $post->id }}</h1>

            <!-- Form to edit the existing post data -->
            <form action="{{ url('update_post', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf <!-- CSRF token for security -->

                <!-- Post Title -->
                <div class="div_center input_design">
                    <label>Post Title</label>
                    <input type="text" name="title" value="{{ $post->title }}" required>
                </div>

                <!-- Post Description -->
                <div class="div_center input_design">
                    <label>Post Description</label>
                    <textarea name="description" required>{{ $post->description }}</textarea>
                </div>

                <!-- Display Current Thumbnail -->
                <div class="div_center input_design">
                    <label>Current Thumbnail</label>
                    @if($post->video_link && (empty($post->image) || !file_exists(public_path('postimage/' . $post->image))))
                        <!-- YouTube Thumbnail if the image is deleted or missing -->
                        <img class="img_adjustment" src="{{ $post->thumbnail }}" alt="YouTube Thumbnail">
                    @elseif(!empty($post->image) && file_exists(public_path('postimage/' . $post->image)))
                        <!-- Display Uploaded Image if it exists -->
                        <img class="img_adjustment" src="/postimage/{{ $post->image }}" alt="Uploaded Image">
                        @if($post->video_link)
                            <!-- Option to reset to YouTube Thumbnail -->
                            <a href="{{ url('resetThumb/'.$post->id) }}" class="btn btn-warning">Reset to YouTube Thumbnail</a>
                        @endif
                    @else
                        <!-- Default Thumbnail if no image is set -->
                        <img class="img_adjustment" src="/defaultThumbnail/default.jpg" alt="Default Thumbnail">
                    @endif
                </div>

                <!-- Option to update post image -->
                <div class="div_center input_design">
                    <label>Update Image</label>
                    <input type="file" name="image">
                </div>

                <!-- YouTube Link Field -->
                <div class="div_center input_design">
                    <label>YouTube Link (if applicable)</label>
                    <input type="text" name="video_link" value="{{ $post->video_link }}">
                    @if($post->video_link)
                        <!-- Button to delete the YouTube link -->
                        <a href="{{ url('delete_youtube_link/'.$post->id) }}" class="btn btn-danger">Delete YouTube Link</a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="div_center input_design">
                    <input type="submit" value="Update Post" class="submitBtn">
                </div>

            </form>
            <!-- End of Edit Post Form -->
        </div>
    </div>

    @include('admin.footer') <!-- Include the footer for the admin page -->
</body>
</html>
