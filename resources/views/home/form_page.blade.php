<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/public">
    <style type="text/css">
        /* Styling for the container section */
        .div_design {
            text-align: center;
            padding: 50px;
            background-color: #2c2c2c; /* Dark background color for contrast */
        }

        /* Styling for form labels */
        label {
            font-size: 18px;
            font-weight: bold;
            color: white;
            display: block;
            margin-bottom: 5px;
        }

        /* Styling for individual form fields */
        .field_design {
            margin-bottom: 20px;
        }

        /* Styling for the form container */
        .form_container {
            max-width: 600px;
            margin: auto;
            background-color: #3d3d3d;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Styling for the title */
        .title_design {
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: bold;
            color: #fff;
        }

        /* Styling for the submit button */
        .btn-submit {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        /* Styling for the image preview */
        .img-preview {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 20px auto;
        }
    </style>
    @include('home.homecss') <!-- Include external CSS -->
</head>
<body>
    <!-- Header section with the navigation bar -->
    <div class="header_section">
        @include('home.header')

        <!-- Displaying success message if form update was successful -->
        @if(session()->has('message'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
            {{ session()->get('message') }}
        </div>
        @endif

        <!-- Form to update the volunteer form -->
        <div class="div_design">
            <div class="form_container">
                <h1 class="title_design">Update Volunteer Form</h1>

                <!-- Start of the form to update form data -->
                <form action="{{ url('update_formData', $forms->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf <!-- CSRF token for security (DO NOT DELETE THIS) -->

                    <!-- Title field for the form -->
                    <div class="field_design">
                        <label>Title</label>
                        <input type="text" name="title" value="{{$forms->name}}" required>
                    </div>

                    <!-- Description field for the form -->
                    <div class="field_design">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4" required>{{ $forms->description }}</textarea>
                    </div>

                    <!-- Link field for the form -->
                    <div class="field_design">
                        <label for="link">Link</label>
                        <textarea id="link" name="link" class="form-control" rows="2" required>{{ $forms->link }}</textarea>
                    </div>

                    <!-- Image Preview and Upload Section -->
                    <div class="field_design">
                        <label for="image">Form Image</label>
                        <!-- Display the current form image if available, else show a default image -->
                        <img class="img-preview" src="{{ asset('formImage/' . ($forms->image ?? 'defaultForm.png')) }}" alt="Current Form Image">
                        <input type="file" name="image" accept="image/*">
                    </div>

                    <!-- Option to reset to the default image -->
                    @if($forms->image && file_exists(public_path('formImage/' . $forms->image)))
                    <div class="field_design text-center">
                        <a href="{{ url('resetFormImage', $forms->id) }}" class="btn-submit">Reset to Default Image</a>
                    </div>
                    @endif

                    <!-- Submit Button to update the form -->
                    <div class="field_design text-center">
                        <button type="submit" class="btn-submit">Update Form</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End of update form -->

    </div>

    <!-- Include footer content -->
    @include('home.footer')
</body>
</html>
