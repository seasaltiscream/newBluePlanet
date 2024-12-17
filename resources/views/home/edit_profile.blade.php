<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        /* Styling for the main container */
        .div_design {
            text-align: center;
            padding: 30px;
            background-color: #1d1d1d; /* Dark background for better contrast */
        }
        /* Styling for the title */
        .title_design {
            font-size: 30px;
            font-weight: bold;
            color: white;
            padding: 30px;
        }
        /* Styling for labels */
        label {
            display: inline-block;
            width: 200px;
            color: white;
            font-size: 18px;
            font-weight: bold;
        }
        /* Styling for form fields */
        .field_design {
            padding: 15px;
        }
        /* Styling for input fields */
        .field_design input {
            padding: 10px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        /* Styling for the save button */
        .btn_save {
            padding: 10px 20px;
            background-color: #337ab7;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn_save:hover {
            background-color: #286090;
        }
        /* Styling for the profile image */
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }
    </style>
    <!-- Include external CSS styles -->
    @include('home.homecss')
</head>
<body>
    <!-- Include header content -->
    @include('home.header')

    <div class="div_design">
        <h1 class="title_design">Edit Profile</h1>

        <!-- Form to update user profile -->
        <form action="{{ url('update_profile') }}" method="POST" enctype="multipart/form-data">
            @csrf <!-- CSRF token for security (DO NOT DELETE THIS) -->

            <!-- Profile Picture Section -->
            <div class="field_design">
                <label>Profile Picture</label>

                <!-- Display current profile picture if exists -->
                @if($user->profile_photo_path)
                    <img class="profile-image" src="{{ asset($user->profile_photo_path) }}" alt="Profile Photo">
                @else
                    <!-- Default profile picture based on user type -->
                    @if($user->userType === 'admin')
                        <img class="profile-image" src="{{ asset('profileAdmin/defaultProfile.png') }}" alt="Admin Default Avatar">
                    @else
                        <img class="profile-image" src="{{ asset('profileUser/defaultProfile.png') }}" alt="User Default Avatar">
                    @endif
                @endif
                
                <!-- File input for uploading a new profile picture -->
                <input type="file" name="profile_photo" accept="image/*">
            </div>

            <!-- Username Field -->
            <div class="field_design">
                <label>Username</label>
                <input type="text" name="username" value="{{ $user->name }}" required> <!-- Pre-filled with current username -->
            </div>

            <!-- Email Field -->
            <div class="field_design">
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required> <!-- Pre-filled with current email -->
            </div>

            <!-- Phone Number Field (Optional) -->
            <div class="field_design">
                <label>Phone Number</label>
                <input type="text" name="phone" value="{{ $user->phone ?? '' }}" placeholder="Enter phone number (optional)">
            </div>

            <!-- Password Field (Optional) -->
            <div class="field_design">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter new password (optional)">
            </div>

            <!-- Save Changes Button -->
            <div class="field_design">
                <input type="submit" value="Save Changes" class="btn_save">
            </div>
        </form>
    </div>

    <!-- Include footer content -->
    @include('home.footer')
</body>
</html>
