

<!-- these are the blog thatll be displayed at home and blog page (I forgot to rename it) -->
<!-- feel free to otak atik how itll look like -->


<!-- Blog Posts Section -->
<div class="services_section layout_padding">
    <div class="container bg-blue-900">
        <h1 class="services_taital text-white">Blog Posts</h1>
        <div class="services_section_2">
            <div class="row">
                <!-- Check if there are any posts -->
                @forelse($posts as $post)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg">
                            <!-- Check if the post has a video link -->
                               @if($post->video_link)
                                        @if(!empty($post->image) && file_exists(public_path('postimage/' . $post->image)))
                                            <!-- Video link with image -->
                                            <img src="{{ asset('postimage/' . $post->image) }}" alt="Post Image" style="height: 200px; object-fit: cover;">
                                        @else
                                            <!-- Video link with YouTube thumbnail -->
                                            <img src="{{ $post->thumbnail }}" alt="YouTube Thumbnail" style="height: 200px; object-fit: cover;">
                                        @endif
                                    @elseif(!empty($post->image) && file_exists(public_path('postimage/' . $post->image)))
                                        <!-- No video link, but image exists -->
                                        <img src="{{ asset('postimage/' . $post->image) }}" alt="Post Image" style="height: 200px; object-fit: cover;">
                                    @else
                                        <!-- No video link or image, default thumbnail -->
                                        <img src="{{ asset('defaultThumbnail/defaultThumbnail.jpg') }}" alt="Default Thumbnail" style="height: 200px; object-fit: cover;">
                                    @endif
                            <div class="card-body">
                                <h4 class="card-title">{{ $post->title }}</h4>
                                <p class="card-text">Posted by <strong>{{ $post->name }}</strong></p>
                                <a href="{{ url('post_details', $post->id) }}" class="btn btn-primary w-100">Read More</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-white">No blog posts available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>


