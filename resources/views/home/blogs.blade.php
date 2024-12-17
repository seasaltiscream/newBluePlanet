<!-- Blog Posts Section -->
<!-- This section displays blog posts, either on the home page or blog page. 
     The variable $posts holds the blog data. Feel free to adjust the layout or appearance as needed. -->

<div class="services_section layout_padding">
    <div class="container bg-blue-900">
        <!-- Section Title -->
        <h1 class="services_taital text-white">Blog Posts</h1>

        <!-- Blog Post List -->
        <div class="services_section_2">
            <div class="row">
                <!-- Check if there are any blog posts available -->
                @forelse($posts as $post)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg">
                            
                            <!-- Check if the post has a video link -->
                            @if($post->video_link)
                                <!-- If there is a video link, check if an image exists -->
                                @if(!empty($post->image) && file_exists(public_path('postimage/' . $post->image)))
                                    <!-- Display post image if it exists -->
                                    <img src="{{ asset('postimage/' . $post->image) }}" alt="Post Image" style="height: 200px; object-fit: cover;">
                                @else
                                    <!-- Display YouTube thumbnail if no post image exists -->
                                    <img src="{{ $post->thumbnail }}" alt="YouTube Thumbnail" style="height: 200px; object-fit: cover;">
                                @endif
                            @elseif(!empty($post->image) && file_exists(public_path('postimage/' . $post->image)))
                                <!-- If no video link, but an image exists, display the image -->
                                <img src="{{ asset('postimage/' . $post->image) }}" alt="Post Image" style="height: 200px; object-fit: cover;">
                            @else
                                <!-- If neither video link nor image exists, display the default thumbnail -->
                                <img src="{{ asset('defaultThumbnail/defaultThumbnail.jpg') }}" alt="Default Thumbnail" style="height: 200px; object-fit: cover;">
                            @endif

                            <!-- Card Body -->
                            <div class="card-body">
                                <!-- Post Title -->
                                <h4 class="card-title">{{ $post->title }}</h4>
                                <!-- Post Author -->
                                <p class="card-text">Posted by <strong>{{ $post->name }}</strong></p>
                                <!-- Read More Button -->
                                <a href="{{ url('post_details', $post->id) }}" class="btn btn-primary w-100">Read More</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- If no posts are found, show a message -->
                    <div class="col-12">
                        <p class="text-white">No blog posts available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

