<!DOCTYPE html>
<html lang="en">
   <head>
      <base href="/public">
      <!-- basic -->
      <style type="text/css">
          .div_design {
              text-align: center;
              padding: 70px;
              background-color: #000000;
          }

          .img_adjustment {
              max-width: 100%;  /* Responsive width */
              max-height: 400px; /* Limit the height */
              width: auto;
              height: auto;
              display: block;
              margin: auto;
          }

          label {
              font-size: 20px;
              font-weight: bold;
              width: 200px;
              color: white;
          }

          .input_design {
              padding: 30px;
          }

          .title_design {
              padding: 30px;
              font-size: 30px;
              font-weight: bold;
              color: white;
          }

          .btn {
              padding: 10px 20px;
              font-size: 18px;
              margin-top: 10px;
              text-decoration: none;
          }

          .btn-danger {
              background-color: #ff4d4d; /* Lighter red */
              color: white;
          }

          .btn-warning {
              background-color: #ffa31a; /* Brighter orange */
              color: white;
          }

          .btn-outline-secondary {
              background-color: #6c757d; /* Secondary color */
              color: white;
          }

          .btn:hover {
              opacity: 0.8;
          }
      </style>

      @include('home.homecss')
   </head>
   <body>
      <!-- header section start -->
      <div class="header_section">
        @include('home.header')
        
        <!-- Confirmation message for update -->
        @if(session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                {{session()->get('message')}}
            </div>
        @endif
        
        <!-- post fields -->
        <div class="div_design">
            <h1 class="title_design">Update Post</h1>
            <form action="{{ url('update_postData', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Post Title -->
                <div class="input_design">
                    <label>Title</label>
                    <input type="text" name="title" value="{{$data->title}}" required>
                </div>

                <!-- Post Description -->
                <div class="input_design">
                    <label>Description</label>
                    <textarea name="description" required>{{$data->description}}</textarea>
                </div>

                <!-- Display Current Thumbnail -->
                <div class="input_design">
                    <label>Current Thumbnail</label>
                    @if($data->image && file_exists(public_path('postimage/' . $data->image)))
                        <!-- Uploaded Image Thumbnail -->
                        <img class="img_adjustment" src="/postimage/{{$data->image}}" alt="Uploaded Image">
                    @elseif($data->video_link)
                        <!-- YouTube Thumbnail -->
                        <img class="img_adjustment" src="{{$data->thumbnail}}" alt="YouTube Thumbnail">
                    @else
                        <!-- Default Thumbnail -->
                        <img class="img_adjustment" src="/defaultThumbnail/defaultThumbnail.jpg" alt="Default Thumbnail">
                    @endif

                    <!-- Reset Thumbnail Button (if no YouTube link and user uploaded an image) -->
                    @if(!$data->video_link && $data->image)
                        <a href="{{ url('resetThumb/'.$data->id) }}" class="btn btn-warning">Reset to Default Thumbnail</a>
                    @elseif($data->video_link && $data->image)
                        <a href="{{ url('resetThumb/'.$data->id) }}" class="btn btn-warning">Reset to YouTube Thumbnail</a>
                    @endif
                </div>

                <!-- Update Post Image -->
                <div class="input_design">
                    <label>Update Image</label>
                    <input type="file" name="image">
                </div>

                <!-- YouTube Link Field -->
                <div class="input_design">
                    <label>YouTube Link (if applicable)</label>
                    <input type="text" name="video_link" value="{{$data->video_link}}">
                    @if($data->video_link)
                        <!-- Button to delete the YouTube link -->
                        <a href="{{ url('deleteYoutubeLink/'.$data->id) }}" class="btn btn-danger">Delete YouTube Link</a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="input_design">
                    <input type="submit" class="btn btn-outline-secondary" value="Update Post">
                </div>
            </form>
        </div>
      </div>
      <!-- post fields -->

      @include('home.footer')
   </body>
</html>
