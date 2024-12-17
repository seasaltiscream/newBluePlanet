<!-- Page to Create a Volunteer Form -->
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
   
   <!-- Header section of the page -->
   <div class="header_section">
      <!-- Include header content from home.header -->
      @include('home.header')

      <!-- Form to Create a Volunteer Form -->
      <div class="div_design">
         <!-- Page Title -->
         <h class="title_design">Add Volunteer Form</h>
         
         <!-- Form for adding a new volunteer form -->
         <form action="{{url('user_form')}}" method="POST" enctype="multipart/form-data"> 
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

            <!-- Link input field -->
            <div class="field_design">
               <label>Link</label>
               <textarea name="link"></textarea>
            </div>

            <!-- Image upload field -->
            <div class="field_design">
               <label>Upload Image</label>
               <input type="file" name="image">
            </div>

            <!-- Submit button to add the form -->
            <div class="field_design">
               <input type="submit" value="Add Post" class="btn btn-outline -secondary">
            </div>
         </form>
      </div>
      <!-- End of form section -->
   </div>

   <!-- Include footer content from home.footer -->
   @include('home.footer')
</body>
</html>
