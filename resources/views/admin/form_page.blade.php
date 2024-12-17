<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
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

        <!-- Success message -->
          @if(session()->has('message'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert" area-hidden="true">
                    X
                </button>
                {{ session()->get('message') }}
            </div>
          @endif

          <!-- form fields -->
            <h1 class="post_title">Add Form</h1>
            <div>
                <form action="{{url('add_form')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Title -->
                    <div class="div_center">
                        <label>Title</label>
                        <input type="text" name="name" required>
                    </div>

                    <!-- Description -->
                    <div class="div_center">
                        <label>Description</label>
                        <textarea name="description" rows="4" required></textarea>
                    </div>

                    <!-- Link -->
                    <div class="div_center">
                        <label>Link</label>
                        <textarea name="link" rows="2" required></textarea>
                    </div>

                    <!-- Image -->
                    <div class="div_center">
                        <label>Image</label>
                        <input type="file" name="image">
                    </div>

                    <!-- Submit Button -->
                    <div class="div_center">
                        <input type="submit" class="submitBtn" value="Add Form">
                    </div>

                </form>
            </div>

        </div>
        @include('admin.footer')
  </body>
</html>
