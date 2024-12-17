<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css') <!-- Includes the external CSS file for admin styles -->

    <style type="text/css">
        /* Styling for the post title */
        .post_title{
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            padding: 30px;
            color: white;
        }

        /* Centering the content inside a container */
        .div_center{
          text-align: center;
          padding: 30px;
        }

        /* Styling for the labels */
        label{
          display: inline-block;
          width: 200px;
        }

        /* Styling for the input fields and text areas */
        input[type="text"], input[type="file"], textarea{
          width: 300px;
          padding: 5px;
        }
    </style>
  </head>
  <body>
    @include('admin.header') <!-- Includes the header for the admin page -->

    <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation -->
        @include('admin.sidebar') <!-- Includes the sidebar for the admin page -->
      <!-- Sidebar Navigation end-->

      <div class="page-content">

        <!-- Display success message after form submission -->
        @if(session()->has('message'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert" area-hidden="true">X</button>
              {{session()->get('message')}}
            </div>
        @endif

        <!-- Add Post Page Title -->
        <h1 class="post_title">Add Post</h1>

        <!-- Form to add a new post -->
        <div>
            <form action="{{url('add_post')}}" method="POST" enctype="multipart/form-data">
                @csrf <!-- CSRF token for security -->

                <!-- Post Title Field -->
                <div class="div_center">
                    <label>Title</label>
                    <input type="text" name="title">
                </div>

                <!-- Post Description Field -->
                <div class="div_center">
                    <label>Description</label>
                    <textarea name="description" rows="4" required></textarea>
                </div>

                <!-- Video Link (YouTube) Field -->
                <div class="div_center">
                    <label>Video Link (YouTube)</label>
                    <input type="text" name="video_link">
                </div>

                <!-- Thumbnail Image Upload Field -->
                <div class="div_center">
                    <label>Thumbnail Image (Optional)</label>
                    <input type="file" name="image">
                </div>

                <!-- Submit Button to add the post -->
                <div class="div_center">
                    <input type="submit" class="submitBtn" value="Add Post">
                </div>

            </form>
        </div>

      </div>
      @include('admin.footer') <!-- Includes the footer for the admin page -->

  </body>
</html>
