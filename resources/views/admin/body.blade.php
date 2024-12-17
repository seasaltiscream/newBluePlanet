<div class="page-content">
    <div class="container">
        <!-- Newest Pending or Active Posts Section -->
        <div class="section">
            <h2>Pending or Active Posts</h2>
            <div class="row">
                @if($filteredPosts && $filteredPosts->isEmpty())
                    <p>No posts available with the status "pending" or "active".</p>
                @else
                    @foreach($filteredPosts as $post)
                        <div class="col-md-4">
                            <div class="card">
                                <!-- Thumbnail logic adjustment -->
                                <div class="card-img-top">
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
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                    <p class="card-text">{{ Str::limit($post->description, 100, '...') }}</p>
                                    <p>Status: <strong>{{ ucfirst($post->post_status) }}</strong></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- Add a button to view all posts -->
            <div class="text-center mt-3">
                <a href="{{ url('/show_post') }}" class="btn btn-primary">Check All Posts</a>
            </div>
        </div>
        <!-- Newest Pending or Active Forms Section -->
        <div class="section mt-5">
            <h2>Pending or Active Forms</h2>
            <div class="row">
                @if($filteredForms && $filteredForms->isEmpty())
                    <p>No forms available with the status "pending" or "active".</p>
                @else
                    @foreach($filteredForms as $form)
                        <div class="col-md-4">
                            <div class="card">
                                <!-- Check if the form has an image, if not, don't show the image -->
                                @if($form->image)
                                    <img src="{{ asset('formImage/' . $form->image) }}" class="card-img-top" alt="Form Image" style="height: 200px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('defaultForm.png') }}" class="card-img-top" alt="Default Form Image" style="height: 200px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $form->name }}</h5>
                                    <p class="card-text">{{ Str::limit($form->description, 100, '...') }}</p>
                                    <p>Status: <strong>{{ ucfirst($form->status) }}</strong></p>
                                    <a href="{{ $form->link }}" target="_blank" class="btn btn-success">View Form</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- Add a button to view all forms -->
            <div class="text-center mt-3">
                <a href="{{ url('/show_form') }}" class="btn btn-success">Check All Forms</a>
            </div>
        </div>
    </div>
</div>
