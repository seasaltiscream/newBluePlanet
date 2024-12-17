<!DOCTYPE html>
<html lang="en">
<head>
   <base href="/public">
   <!-- Basic Styles -->
   <style type="text/css">
       .div_design {
           text-align: center;
           padding: 50px 20px;
           background-color: #000000;
           border-radius: 8px;
       }

       .img_adjustment {
           max-width: 100%;  
           max-height: 400px; 
           width: auto;
           height: auto;
           display: block;
           margin: auto;
           border-radius: 8px;
       }

       label {
           font-size: 20px;
           font-weight: bold;
           width: 200px;
           color: white;
           display: inline-block;
           margin-bottom: 10px;
       }

       input[type="text"], textarea, input[type="file"] {
           width: 100%;
           padding: 10px;
           font-size: 16px;
           margin-top: 5px;
           border-radius: 5px;
       }

       .input_design {
           margin-bottom: 20px;
           text-align: left;
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
           border-radius: 5px;
           cursor: pointer;
       }

       .btn-danger {
           background-color: #ff4d4d;
           color: white;
       }

       .btn-warning {
           background-color: #ffa31a;
           color: white;
       }

       .btn-outline-secondary {
           background-color: #6c757d;
           color: white;
       }

       .btn:hover {
           opacity: 0.8;
       }

       .alert {
           background-color: #4CAF50;
           color: white;
           padding: 15px;
           margin-bottom: 20px;
           border-radius: 5px;
       }

       /* Responsive Design */
       @media screen and (max-width: 768px) {
           .div_design {
               padding: 30px 15px;
           }

           .img_adjustment {
               max-height: 250px;
           }

           label, input[type="text"], textarea, input[type="file"] {
               width: 100%;
           }
       }
   </style>

   @include('home.homecss')
</head>
<body>
   <!-- Header Section -->
   <div class="header_section">
      @include('home.header')
      
      <!-- Confirmation message for update -->
      @if(session()->has('message'))
         <div class="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
            {{session()->get('message')}}
         </div>
      @endif

      <!-- Post Update Form -->
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

               <!-- Reset Thumbnail Button -->
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
   <!-- Post Fields End -->

   @include('home.footer')
</body>
</html>
