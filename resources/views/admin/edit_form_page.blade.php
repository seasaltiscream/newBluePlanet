<!DOCTYPE html>
<html>
  <head> 
    <base href="/public">
    @include('admin.css') <!-- Includes the external CSS file for admin styles -->

    <style type="text/css">
        /* Styling for the title of the form edit page */
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

        /* Styling for form labels */
        label{
          display: inline-block;
          width: 200px;
        }

        /* Styling for the submit button */
        .submitBtn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Hover effect for the submit button */
        .submitBtn:hover {
            background-color: #0056b3;
        }

        /* Styling for the image preview */
        .img-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-top: 10px;
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
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                {{session()->get('message')}}
            </div>
        @endif

        <!-- Title of the form edit page -->
        <h1 class="post_title">Edit Form {{$form->id}}</h1>

        <!-- Form to edit the existing form data -->
        <form action="{{url('update_form', $form->id)}}" method="POST" enctype="multipart/form-data">
            @csrf <!-- CSRF token for security -->

            <!-- Input field for the form name -->
            <div class="div_center">
                <label>Form Name</label>
                <input type="text" name="name" value="{{$form->name}}" required>
            </div>

            <!-- Textarea for the form description -->
            <div class="div_center">
                <label>Description</label>
                <textarea name="description" rows="4" required>{{$form->description}}</textarea>
            </div>

            <!-- Textarea for the form link -->
            <div class="div_center">
                <label>Link</label>
                <textarea name="link" rows="2" required>{{$form->link}}</textarea>
            </div>

            <!-- Optional field to upload a new form image -->
            <div class="div_center">
                <label>Form Image (Optional)</label>
                <input type="file" name="image">
                <!-- Display the current form image or default image if none exists -->
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

            <!-- Button to reset the image to the default one -->
            <div class="div_center">
                <a href="{{ url('resetFormImage', $form->id) }}" class="submitBtn">Reset to Default Image</a>
            </div>

            <!-- Submit button to update the form -->
            <div class="div_center">
                <input type="submit" value="Update Form" class="submitBtn">
            </div>

        </form>
        <!-- End of form to edit the existing form data -->

      </div>

    </div>

    @include('admin.footer') <!-- Include the footer for the admin page -->
  </body>
</html>
