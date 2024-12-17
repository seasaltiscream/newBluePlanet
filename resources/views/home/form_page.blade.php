<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/public">
    <style type="text/css">
        .div_design {
            text-align: center;
            padding: 50px;
            background-color: #2c2c2c;
        }

        label {
            font-size: 18px;
            font-weight: bold;
            color: white;
            display: block;
            margin-bottom: 5px;
        }

        .field_design {
            margin-bottom: 20px;
        }

        .form_container {
            max-width: 600px;
            margin: auto;
            background-color: #3d3d3d;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .title_design {
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: bold;
            color: #fff;
        }

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

        .img-preview {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 20px auto;
        }
    </style>
    @include('home.homecss')
</head>
<body>
    <div class="header_section">
        @include('home.header')

        <!-- Confirmation message -->
        @if(session()->has('message'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
            {{ session()->get('message') }}
        </div>
        @endif

        <!-- Update form fields -->
        <div class="div_design">
            <div class="form_container">
                <h1 class="title_design">Update Volunteer Form</h1>
                <form action="{{ url('update_formData', $forms->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Title Field -->
                    <div class="field_design">
                        <label>Title</label>
                        <input type="text" name="title" value="{{$forms->name}}" required>
                    </div>

                    <!-- Description Field -->
                    <div class="field_design">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4" required>{{ $forms->description }}</textarea>
                    </div>

                    <!-- Link Field -->
                    <div class="field_design">
                        <label for="link">Link</label>
                        <textarea id="link" name="link" class="form-control" rows="2" required>{{ $forms->link }}</textarea>
                    </div>

                    <!-- Image Preview and Upload -->
                    <div class="field_design">
                        <label for="image">Form Image</label>
                        <!-- Display current image -->
                        <img class="img-preview" src="{{ asset('formImage/' . ($forms->image ?? 'defaultForm.png')) }}" alt="Current Form Image">
                        <input type="file" name="image" accept="image/*">
                    </div>

                    <!-- Reset Image Button -->
                    @if($forms->image && file_exists(public_path('formImage/' . $forms->image)))
                    <div class="field_design text-center">
                        <a href="{{ url('resetFormImage', $forms->id) }}" class="btn-submit">Reset to Default Image</a>
                    </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="field_design text-center">
                        <button type="submit" class="btn-submit">Update Form</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Update form end -->

    </div>

    @include('home.footer')
</body>
</html>
