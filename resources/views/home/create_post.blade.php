<!-- a page where u wanna make ur own post -->

<!DOCTYPE html>
<html lang="en">
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
   <body>
        <!-- I forgot pls do note that make sure not to delete the sweetalert -->
        @include('sweetalert::alert')
        
      <div class="header_section">
        @include('home.header')

      <!-- fields for filling out ur post -->
      <div class="div_design">
        <h class="title_design">Add Post</h>
        <form action="{{url('user_post')}}" method="POST" enctype="multipart/form-data"> 
            @csrf <!-- idk what @csrf actually does but dont delete it -->
            
            <div class="field_design">
                <label>Title</label>
                 <input type="text" name="title">
            </div>

             <div class="field_design">
                <label>Description</label>
                 <textarea name="description"></textarea>
            </div>

             <div class="field_design">
                <label>Image</label>
                 <input type="file" name="image">
            </div>

            <div class="field_design">
                <label>Video Link (YouTube)</label>
                <input type="text" name="video_link">
            </div>

            <div class="field_design">
                <input type="submit" value="Add Post" class="btn btn-outline-secondary">
            </div>
        </form>
      </div>
      <!-- ----------------------------------- -->
  
       @include('home.footer')
</html>
