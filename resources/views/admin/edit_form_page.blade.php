<!DOCTYPE html>
<html>
  <head> 
    <base href="/public">
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

        .submitBtn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submitBtn:hover {
            background-color: #0056b3;
        }

        .img-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-top: 10px;
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
        @if(session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                {{session()->get('message')}}
            </div>
        @endif

        <!-- edit form fields -->
        <h1 class="post_title">Edit Form {{$form->id}}</h1>

        <form action="{{url('update_form', $form->id)}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="div_center">
                <label>Form Name</label>
                <input type="text" name="name" value="{{$form->name}}" required>
            </div>

            <div class="div_center">
                <label>Description</label>
                <textarea name="description" rows="4" required>{{$form->description}}</textarea>
            </div>

            <div class="div_center">
                <label>Link</label>
                <textarea name="link" rows="2" required>{{$form->link}}</textarea>
            </div>
<div class="div_center">
    <label>Form Image (Optional)</label>
    <input type="file" name="image">
    @if($form->image && file_exists(public_path('formImage/' . $form->image)))
        <div>
            <label>Current Image:</label>
            <img class="img-preview" src="{{ asset('formImage/' . $form->image) }}" alt="Current Form Image">
        </div>
    @else
        <div>
            <label>Current Image:</label>
            <img class="img-preview" src="{{ asset('formImage/defaultForm.png') }}" alt="Default Form Image">
        </div>
    @endif
</div>


<!-- Reset Image Button -->
<div class="div_center">
    <a href="{{ url('resetFormImage', $form->id) }}" class="submitBtn">Reset to Default Image</a>
</div>



            <div class="div_center">
                <input type="submit" value="Update Form" class="submitBtn">
            </div>

        </form>
        <!-- edit form fields -->

      </div>

    </div>

    @include('admin.footer')
  </body>
</html>
