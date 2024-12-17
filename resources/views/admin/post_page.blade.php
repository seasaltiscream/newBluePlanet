<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css ')
    <style type="text/css">
        .post_title{
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            padding: 30px;
            color: white;
        }

        .div_center{
          text-align: center;
          padding: 30px;
        }

        label{
          display: inline-block;
          width: 200px;
        }

        input[type="text"], input[type="file"], textarea{
          width: 300px;
          padding: 5px;
        }

    </style>
  </head>
  <body>
    @include('admin.header')
    <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
        @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
        <div class="page-content">

        <!-- I guess u know the pattern -->
          @if(session()->has('message'))
            <div class="alert alert-success">
              <!-- bootstrap alert -->
                <button type="button" class="close" data-dismiss="alert" area-hidden="true">
                    X
                </button>
                {{session()->get('message')}}
            </div>
          @endif
          <!-- I guess u know the pattern -->

          <!-- form fields -->
            <h1 class="post_title">Add Post</h1>
            <div>
                <form action="{{url('add_post')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="div_center">
                        <label>Title</label>
                        <input type="text" name="title">
                    </div>

                    <div class="div_center">
                        <label>Description</label>
                        <textarea name="description" rows="4" required></textarea>
                    </div>

                    <div class="div_center">
                        <label>Video Link (YouTube)</label>
                        <input type="text" name="video_link">
                    </div>


                    <div class="div_center">
                        <label>Thumbnail Image (Optional)</label>
                       <input type="file" name="image">
                    </div>


                    <div class="div_center">
                        <input type="submit" class="submitBtn" value="Add Post">
                    </div>

                </form>
                <!-- form fields -->

            </div>

        </div>
        <!-- to make sure the body is black, I think its paired with the page-content -->
        @include('admin.footer')
  </body>
</html>
