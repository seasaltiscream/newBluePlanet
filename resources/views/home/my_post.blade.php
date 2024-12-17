<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
       <style type="text/css">

        .post_design{
            padding: 30px;
            text-align: center;
            background-color: #06402B;
        }

        .title_design{
            color: white;
            font-weight: bold;
            padding: 15px;
            font-size: 30px;
        }

        .p_design{
            color: whitesmoke;
            font-weight: bold;
            padding: 15px;
            font-size: 17px;
        }

        .img_design{
            max-width: 100%;  /* Responsive width */
            max-height: 400px; /* Limit the height */
            width: auto;
            height: auto;
            display: block;
            margin: auto;      /* Center the image */
        }

       </style>

        @include('home.homecss')
   </head>
   <body>
      <!-- header section start -->
      <div class="header_section">
        @include('home.header')

        <!-- Confirmation message -->
        @if(session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                {{session()->get('message')}}
            </div>
        @endif
        <!-- Confirmation message -->

        <!-- User posts -->
        @foreach($data as $data)
            <div class="post_design">
                <!-- Check if there is a YouTube link -->
                @if($data->video_link)
                    <!-- Display YouTube video thumbnail directly using the URL from the database -->
                    <img class="img_design" src="{{$data->thumbnail}}" alt="YouTube Thumbnail">
                    <p class="p_design"><b>Video Link:</b> <a href="{{$data->video_link}}" target="_blank">{{$data->video_link}}</a></p>
                @else
                    <!-- Check if an image exists, otherwise use default thumbnail -->
                    <img class="img_design" src="{{ $data->thumbnail ?? ($data->image ? '/postimage/' . $data->image : '/defaultThumbnail/defaultThumbnail.jpg') }}" alt="Post Image">
                @endif
                <h3 class="title_design">{{$data->title}}</h3>
                <p class="p_design">{{$data->description}}</p>
                <p class="p_design"><b>Status:</b> {{$data->post_status}}</p>

                <!-- Buttons to delete or update the post -->
                <a onclick="return confirm('Are you sure to delete this?')" href="{{url('deleteUserPost', $data->id)}}" class="btn btn-danger">Delete Post</a>
                <a href="{{url('update_user_post', $data->id)}}" class="btn btn-primary">Update</a>
            </div>
        @endforeach
        <!-- User posts -->

      </div>

        @include('home.footer')
   </body>
</html>
