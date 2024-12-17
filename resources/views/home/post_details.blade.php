<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/public">
    @include('home.homecss')
</head>
<body>
    <div class="header_section">
        @include('home.header')
        @include('home.banner')
    </div>

    <div style="text-align: center" class="col-md-12">
        <!-- Title, description, and author -->
        <h1 style="font-size: 2.5em;"><b>{{$post->title}}</b></h1>            
        <h4>{{$post->description}}</h4>
        <p>Posted by <b>{{$post->name}}</b></p>

        <!-- Check if both video link and image exist -->
        @if($post->video_link && $post->image)
            <!-- If both video link and image exist, show uploaded image as thumbnail -->
            <div style="display: flex; justify-content: center; align-items: center; padding: 20px;">
                <img src="/postimage/{{$post->image}}" alt="Post Image" style="max-width: 100%; height: auto;">
            </div>
            
            <!-- Extract YouTube video ID -->
            @php
                preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|\S+?[?&]v=|\S+?v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $post->video_link, $matches);
                $videoId = $matches[1] ?? null;
                $embedUrl = $videoId ? "https://www.youtube.com/embed/$videoId" : null;
            @endphp

            @if($embedUrl)
                <!-- Embed YouTube video below the image -->
                <div style="margin-top: 20px;">
                    <iframe width="560" height="315" src="{{ $embedUrl }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            @endif

        <!-- If only video link exists, show YouTube thumbnail and embed the video -->
        @elseif($post->video_link)
            <!-- Extract YouTube video ID -->
            @php
                preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|\S+?[?&]v=|\S+?v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $post->video_link, $matches);
                $videoId = $matches[1] ?? null;
                $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/$videoId/maxresdefault.jpg" : null;
                $embedUrl = $videoId ? "https://www.youtube.com/embed/$videoId" : null;
            @endphp

            @if($thumbnailUrl)
                <!-- Display YouTube thumbnail if available -->
                <div style="display: flex; justify-content: center; align-items: center; padding: 20px;">
                    <img src="{{ $thumbnailUrl }}" alt="YouTube Thumbnail" style="max-width: 100%; height: auto;">
                </div>
            @endif

            @if($embedUrl)
                <!-- Embed YouTube video -->
                <div style="margin-top: 20px;">
                    <iframe width="560" height="315" src="{{ $embedUrl }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            @endif

        <!-- If only image exists, show the image -->
        @elseif($post->image)
            <div style="display: flex; justify-content: center; align-items: center; padding: 20px;">
                <img src="/postimage/{{$post->image}}" alt="Post Image" style="max-width: 100%; height: auto;">
            </div>
        
        <!-- If neither video nor image is available, show a placeholder -->
        @else
            <div style="display: flex; justify-content: center; align-items: center; padding: 20px;">
                <img src="defaultThumbnail/defaultThumbnail.jpg" alt="Default Thumbnail" style="max-width: 100%; height: auto;">
            </div>
        @endif

        <!-- Additional post content (like post details) -->
        @if($post->content)
            <div style="margin-top: 20px;">
                <h4>Post Content</h4>
                <p>{{$post->content}}</p>
            </div>
        @endif

        <!-- Display any additional user information or features -->
        @if($post->additional_info)
            <div style="margin-top: 20px;">
                <h4>Additional Information</h4>
                <p>{{$post->additional_info}}</p>
            </div>
        @endif
    </div>

    @include('home.footer')
</body>
</html>
