<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css') <!-- Includes the external CSS file for admin styles -->

    <style type="text/css">
        /* Styling for the form title */
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
    @include('admin.header') <!-- Include the header for the admin page -->

    <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation -->
        @include('admin.sidebar') <!-- Include the sidebar for the admin page -->
      <!-- Sidebar Navigation end-->

      <div class="page-content">

        <!-- Display success message after form submission -->
        @if(session()->has('message'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert" area-hidden="true">X</button>
              {{ session()->get('message') }}
            </div>
        @endif

        <!-- Add Form Page Title -->
        <h1 class="post_title">Add Form</h1>

        <!-- Form to add a new form entry -->
        <div>
            <form action="{{url('add_form')}}" method="POST" enctype="multipart/form-data">
                @csrf <!-- CSRF token for security -->

                <!-- Form Title Field -->
                <div class="div_center">
                    <label>Title</label>
                    <input type="text" name="name" required>
                </div>

                <!-- Form Description Field -->
                <div class="div_center">
                    <label>Description</label>
                    <textarea name="description" rows="4" required></textarea>
                </div>

                <!-- Form Link Field -->
                <div class="div_center">
                    <label>Link</label>
                    <textarea name="link" rows="2" required></textarea>
                </div>

                <!-- Image Upload Field -->
                <div class="div_center">
                    <label>Image</label>
                    <input type="file" name="image">
                </div>

                <!-- Submit Button to add the form -->
                <div class="div_center">
                    <input type="submit" class="submitBtn" value="Add Form">
                </div>

            </form>
        </div>

      </div>
      @include('admin.footer') <!-- Include the footer for the admin page -->

  </body>
</html>
