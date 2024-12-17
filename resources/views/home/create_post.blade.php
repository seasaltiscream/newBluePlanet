<!-- Page to Create a New Post -->
<!DOCTYPE html>
<html lang="en">
   <head>
     <style type="text/css">
        /* Custom CSS Styles */
        .div_design{
            text-align: center;
            padding: 30px;
        }

        .title_design{
            font-size: 30px;
            font-weight: bold;
            color: white;
            padding: 30px;
        }

        label{
            display: inline-block;
            width: 200px;
            color: white;
            font-size: 18px;
            font-weight: bold;
        }

        .field_design{
            padding: 25px;
        }
     </style>
    
      <!-- Include external CSS for basic styling -->
        @include('home.homecss')
   </head>
   <body>
        <!-- Include SweetAlert for pop-up messages (e.g., success or error messages) -->
        @include('sweetalert::alert')
        
      <div class="header_section">
        <!-- Include header content from home.header -->
        @include('home.header')

      <!-- Form Section to Add a Post -->
      <div class="div_design">
        <!-- Page Title -->
        <h class="title_design">Add Post</h>
        
        <!-- Form for adding a new post -->
        <form action="{{url('user_post')}}" method="POST" enctype="multipart/form-data"> 
            @csrf 
            <!-- CSRF token for security (DO NOT DELETE this) -->
            
            <!-- Title input field -->
            <div class="field_design">
                <label>Title</label>
                 <input type="text" name="title">
            </div>

            <!-- Description input field -->
            <div class="field_design">
                <label>Description</label>
                 <textarea name="description"></textarea>
            </div>

            <!-- Image upload field -->
            <div class="field_design">
                <label>Image</label>
                 <input type="file" name="image">
            </div>

            <!-- Video Link (YouTube) input field -->
            <div class="field_design">
                <label>Video Link (YouTube)</label>
                <input type="text" name="video_link">
            </div>

            <!-- Submit button to add the post -->
            <div class="field_design">
                <input type="submit" value="Add Post" class="btn btn-outline-secondary">
            </div>
        </form>
      </div>
      <!-- End of form section -->
  
       <!-- Include footer content from home.footer -->
       @include('home.footer')
   </body>
</html>
