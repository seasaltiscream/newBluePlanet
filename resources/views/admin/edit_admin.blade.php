<!DOCTYPE html>
<html>
<head>
    <base href="/public">
    @include('admin.css') <!-- Includes the external CSS file for admin styles -->

    <style type="text/css">
        /* Styling for the title of the profile edit page */
        .edit_profile_title {
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            padding: 30px;
            color: white;
        }

        /* Centering the content inside a container */
        .div_center {
            text-align: center;
            padding: 30px;
        }

        /* Styling for the form labels */
        label {
            display: inline-block;
            width: 200px;
            color: white;
        }

        /* Styling for the profile image (circle shape and fitting) */
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Styling for success alert messages */
        .alert {
            color: green;
            text-align: center;
            padding: 10px;
            background-color: #e8f7e8;
        }

        /* Styling for error alert messages */
        .alert-danger {
            color: red;
            background-color: #f8d7da;
        }

        /* Styling for the submit button */
        .btn_edit {
            background-color: #2c3e50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            width: 100%;
            margin-top: 20px;
        }

        /* Hover effect for the submit button */
        .btn_edit:hover {
            background-color: #34495e;
        }

        /* Styling for the form fields */
        .field_design {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 10px 0;
        }

        /* Container styling for the profile section */
        .profile_container {
            background-color: #34495e;
            padding: 30px;
            border-radius: 10px;
            margin-left: 250px;
            width: calc(100% - 250px);
        }

        /* Styling for the profile form */
        .profile-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Styling for input fields in the form */
        .profile-form input[type="text"], 
        .profile-form input[type="email"], 
        .profile-form input[type="password"],
        .profile-form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
<div class="header_section">
    @include('admin.header') <!-- Include the header for the admin page -->

    <div class="d-flex align-items-stretch">
        @include('admin.sidebar') <!-- Include the sidebar for the admin page -->

        <div class="page-content">
            <div class="profile_container">
                <h1 class="edit_profile_title">Edit Admin Profile</h1>

                <!-- Success message after successful update -->
                @if(session('message'))
                    <div class="alert">{{ session('message') }}</div>
                @endif

                <!-- Display errors if form submission fails -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li> <!-- Display individual errors -->
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form to update the admin profile -->
                <form action="{{ url('updateAdmin') }}" method="POST" enctype="multipart/form-data" class="profile-form">
                    @csrf <!-- CSRF token for security -->

                    <!-- Input field for the username -->
                    <div class="field_design">
                        <label>Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->name) }}">
                    </div>

                    <!-- Input field for the email -->
                    <div class="field_design">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}">
                    </div>

                    <!-- Input field for the phone number -->
                    <div class="field_design">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}">
                    </div>

                    <!-- Input field for the new password -->
                    <div class="field_design">
                        <label>New Password</label>
                        <input type="password" name="password">
                    </div>

                    <!-- Input field for confirming the new password -->
                    <div class="field_design">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation">
                    </div>

                    <!-- Section to display and update the profile picture -->
                    <div class="field_design">
                        <label>Profile Picture</label>
                        <!-- Display current profile picture or default avatar -->
                        @if($user->profile_photo_path)
                            <img class="profile-image" src="{{ asset($user->profile_photo_path) }}" alt="Profile Photo">
                        @else
                            <img class="profile-image" src="{{ asset('profileAdmin/defaultProfile.png') }}" alt="Default Avatar">
                        @endif
                        <br>
                        <!-- Input field for updating the profile picture -->
                        <label>Update Profile Picture</label>
                        <input type="file" name="profile_photo">
                    </div>

                    <!-- Submit button to update the profile -->
                    <div class="field_design">
                        <input type="submit" value="Update Profile" class="btn_edit">
                    </div>
                </form>

            </div>
        </div>
    </div>    

    @include('admin.footer') <!-- Include the footer for the admin page -->
</body>
</html>
