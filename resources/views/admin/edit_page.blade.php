<!DOCTYPE html>
<html>
<head>
    <base href="/public">
    @include('admin.css')

    <style type="text/css">
        .post_title {
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            padding: 30px;
            color: white;
        }

        .div_center {
            text-align: center;
            padding: 30px;
        }

        label {
            font-size: 20px;
            font-weight: bold;
            color: white;
            width: 200px;
            display: inline-block;
        }

        .input_design {
            padding: 20px;
        }

        .img_adjustment {
            max-width: 100%;
            max-height: 400px;
            width: auto;
            height: auto;
            display: block;
            margin: auto;
        }

        .submitBtn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        .submitBtn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    @include('admin.header')
    <div class="d-flex align-items-stretch">
        <!-- Sidebar Navigation -->
        @include('admin.sidebar')
        <!-- Sidebar Navigation end -->

        <div class="page-content">

            <!-- Success message -->
            @if(session()->has('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                    {{ session()->get('message') }}
                </div>
            @endif

            <!-- Edit Post Form -->
            <h1 class="post_title">Edit Post {{ $post->id }}</h1>

            <form action="{{ url('update_post', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

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
<!-- Display Current Thumbnail -->
<!-- Display Current Thumbnail -->
<!-- Display Current Thumbnail -->
<div class="div_center input_design">
    <label>Current Thumbnail</label>
    @if($post->video_link && (empty($post->image) || !file_exists(public_path('postimage/' . $post->image))))
        <!-- YouTube Thumbnail if the image is deleted or missing -->
        <img class="img_adjustment" src="{{ $post->thumbnail }}" alt="YouTube Thumbnail">
    @elseif(!empty($post->image) && file_exists(public_path('postimage/' . $post->image)))
        <!-- Uploaded Image -->
        <img class="img_adjustment" src="/postimage/{{ $post->image }}" alt="Uploaded Image">
        @if($post->video_link)
            <!-- Option to reset to YouTube Thumbnail -->
            <a href="{{ url('resetThumb/'.$post->id) }}" class="btn btn-warning">Reset to YouTube Thumbnail</a>
        @endif
    @else
        <!-- Default Thumbnail -->
        <img class="img_adjustment" src="/defaultThumbnail/default.jpg" alt="Default Thumbnail">
    @endif
</div>

                <!-- Update Post Image -->
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

    @include('admin.footer')
</body>
</html>
