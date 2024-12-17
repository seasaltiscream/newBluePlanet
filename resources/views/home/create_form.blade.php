

<!-- a page where u wanna make ur own form -->


<!DOCTYPE html>
<html lang="en">

<!-- yea basically I gpt the design so -->
   <head>
     <style type="text/css">
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
    
      <!-- basic -->
        @include('home.homecss')
   </head>
    <!-- idk how bootstrap works so -->


   <body>
        @include('sweetalert::alert')
        
      <!-- header section start -->
      <div class="header_section">
        @include('home.header')


      <!-- pretty much the fields for filling out ur form -->
      <div class="div_design">
        <h class="title_design">Add Volunteer Form</h>
        <form action="{{url('user_form')}}" method="POST" enctype="multipart/form-data"> 
            @csrf 
            <!-- idk what @csrf actually does but dont delete it -->
            <div class="field_design">
                <label>Title</label>
                 <input type="text" name="title">
            </div>

             <div class="field_design">
                <label>Description</label>
                 <textarea name="description"></textarea>
            </div>

             <div class="field_design">
                <label>Link</label>
                <textarea name="link"></textarea>
            </div>

            <div class="field_design">
                <label>Upload Image</label>
                <input type="file" name="image">
            </div>


            <div class="field_design">
                <input type="submit" value="Add Post" class="btn btn-outline -secondary">
            </div>
        </form>
      </div>
      <!-- -------------------------------------------------- -->
  
       @include('home.footer')
</html>