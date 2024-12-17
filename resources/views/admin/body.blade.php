


<!-- kena edit gk ya,,, -->




<div class="page-content">
    <div class="container">
        <!-- Newest Pending or Active Posts Section -->
        <div class="section">
            <h2>Pending or Active Posts</h2>
            <div class="row">
                <!-- Check if there are any filtered posts and if they are empty -->
                @if($filteredPosts && $filteredPosts->isEmpty())
                    <p>No posts available with the status "pending" or "active".</p>
                @else
                    <!-- Loop through the filtered posts -->
                    @foreach($filteredPosts as $post)
                        <div class="col-md-4">
                            <div class="card">
                                <!-- Thumbnail logic adjustment based on the existence of video link or image -->
                                <div class="card-img-top">
                                    @if($post->video_link)
                                        @if(!empty($post->image) && file_exists(public_path('postimage/' . $post->image)))
                                            <!-- If post has a video link and an image, show post image -->
                                            <img src="{{ asset('postimage/' . $post->image) }}" alt="Post Image" style="height: 200px; object-fit: cover;">
                                        @else
                                            <!-- If post has a video link but no image, show YouTube thumbnail -->
                                            <img src="{{ $post->thumbnail }}" alt="YouTube Thumbnail" style="height: 200px; object-fit: cover;">
                                        @endif
                                    @elseif(!empty($post->image) && file_exists(public_path('postimage/' . $post->image)))
                                        <!-- If no video link but post has an image, show post image -->
                                        <img src="{{ asset('postimage/' . $post->image) }}" alt="Post Image" style="height: 200px; object-fit: cover;">
                                    @else
                                        <!-- If no video link or image, show default thumbnail -->
                                        <img src="{{ asset('defaultThumbnail/defaultThumbnail.jpg') }}" alt="Default Thumbnail" style="height: 200px; object-fit: cover;">
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                    <p class="card-text">{{ Str::limit($post->description, 100, '...') }}</p>
                                    <p>Status: <strong>{{ ucfirst($post->post_status) }}</strong></p> <!-- Display post status -->
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- Button to view all posts -->
            <div class="text-center mt-3">
                <a href="{{ url('/show_post') }}" class="btn btn-primary">Check All Posts</a>
            </div>
        </div>

        <!-- Newest Pending or Active Forms Section -->
        <div class="section mt-5">
            <h2>Pending or Active Forms</h2>
            <div class="row">
                <!-- Check if there are any filtered forms and if they are empty -->
                @if($filteredForms && $filteredForms->isEmpty())
                    <p>No forms available with the status "pending" or "active".</p>
                @else
                    <!-- Loop through the filtered forms -->
                    @foreach($filteredForms as $form)
                        <div class="col-md-4">
                            <div class="card">
                                <!-- Check if the form has an image, if not, use the default form image -->
                                @if($form->image)
                                    <img src="{{ asset('formImage/' . $form->image) }}" class="card-img-top" alt="Form Image" style="height: 200px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('defaultForm.png') }}" class="card-img-top" alt="Default Form Image" style="height: 200px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $form->name }}</h5>
                                    <p class="card-text">{{ Str::limit($form->description, 100, '...') }}</p> <!-- Truncate description to 100 characters -->
                                    <p>Status: <strong>{{ ucfirst($form->status) }}</strong></p> <!-- Display form status -->
                                    <a href="{{ $form->link }}" target="_blank" class="btn btn-success">View Form</a> <!-- Button to view the form -->
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- Button to view all forms -->
            <div class="text-center mt-3">
                <a href="{{ url('/show_form') }}" class="btn btn-success">Check All Forms</a>
            </div>
        </div>
    </div>
</div>
