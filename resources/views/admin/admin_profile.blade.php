{{-- resources/views/admin/profile.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <base href="/public">
    @include('admin.css') <!-- Include the CSS for the admin layout -->

    <style type="text/css">
        /* Styles for the profile page */
        .title_design {
            font-size: 30px;
            font-weight: bold;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .field_design {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 10px 0;
        }

        label {
            display: inline-block;
            width: 200px;
            color: white;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .btn_edit {
            background-color: blue;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn_edit:hover {
            background-color: darkblue;
        }

        .profile_container {
            background-color: #2c3e50;
            padding: 30px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="header_section">
    @include('admin.header') <!-- Include the header section of the admin layout -->

    <div class="d-flex align-items-stretch">
        @include('admin.sidebar') <!-- Include the sidebar for navigation -->

        <div class="page-content">
            <!-- Profile section -->
            <div class="profile_container">
                <h1 class="title_design">Admin Profile</h1>

                <!-- Display Admin's Username -->
                <div class="field_design">
                    <label>Username</label>
                    <span class="field_value">{{ $user->name }}</span>
                </div>

                <!-- Display Admin's Email -->
                <div class="field_design">
                    <label>Email</label>
                    <span class="field_value">{{ $user->email }}</span>
                </div>

                <!-- Display Admin's Phone Number -->
                <div class="field_design">
                    <label>Phone Number</label>
                    <span class="field_value">{{ $user->phone ?? 'Not Provided' }}</span>
                </div>

                <!-- Display Admin's Role -->
                <div class="field_design">
                    <label>Role</label>
                    <span class="field_value">Admin</span>
                </div>

                <!-- Profile Picture -->
                <div class="field_design">
                    <label>Profile Picture</label>
                    <!-- Check if the user has a profile photo, otherwise show default image -->
                    @if($user->profile_photo_path)
                        <img class="profile-image" src="{{ asset($user->profile_photo_path) }}" alt="Profile Photo">
                    @else
                        @if($user->userType === 'admin')
                            <img class="profile-image" src="{{ asset('profileAdmin/defaultProfile.png') }}" alt="Admin Default Avatar">
                        @else
                            <img class="profile-image" src="{{ asset('profileUser/defaultProfile.png') }}" alt="User Default Avatar">
                        @endif
                    @endif
                </div>

                <!-- Password field, display as **** for security -->
                <div class="field_design">
                    <label>Password</label>
                    <span class="field_value">****</span>  <!-- Password hidden as **** -->
                </div>

                <!-- Button to edit profile -->
                <div class="field_design">
                    <a href="{{ url('edit_admin') }}" class="btn_edit">Edit Profile</a>
                </div>

            </div>
        </div>
    </div>

    @include('admin.footer') <!-- Include the footer section of the admin layout -->
</body>
</html>
