<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        /* Styling for the container holding the profile details */
        .div_design {
            text-align: center;
            padding: 30px;
            background-color: #000000; /* Black background */
            border-radius: 8px;
        }

        /* Title styling for the Profile page */
        .title_design {
            font-size: 30px;
            font-weight: bold;
            color: white;
            padding: 30px;
        }

        /* Label styling for each field */
        label {
            display: inline-block;
            width: 200px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px; /* Add space below the label */
        }

        /* Styling for field values (like username, email, etc.) */
        .field_value {
            display: inline-block;
            width: 300px;
            color: lightgray;
            font-size: 18px;
            text-align: left;
        }

        /* Edit button styling */
        .btn_edit {
            padding: 12px 24px;
            background-color: #5cb85c; /* Green background */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 20px;
        }

        /* Hover effect for the edit button */
        .btn_edit:hover {
            background-color: #4cae4c; /* Darker green when hovered */
        }

        /* Profile image styling: circular shape and object fit */
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover; /* Ensures the image fits inside the circle */
            margin-bottom: 20px; /* Space below the image */
        }

        /* Media query for responsive design on smaller screens */
        @media screen and (max-width: 768px) {
            /* Reduce padding for small screens */
            .div_design {
                padding: 20px 10px;
            }

            /* Reduce the title size on small screens */
            .title_design {
                font-size: 24px;
            }

            /* Adjust label and field value sizes and alignment for smaller screens */
            label, .field_value {
                font-size: 16px;
                width: 100%;
                text-align: left;
            }

            /* Resize the button text for smaller screens */
            .btn_edit {
                font-size: 16px;
                padding: 10px 20px;
            }

            /* Resize profile image for small screens */
            .profile-image {
                width: 120px;
                height: 120px;
            }
        }
    </style>
    @include('home.homecss')
</head>
<body>
    
    <div class="header_section">
        @include('home.header')

        <!-- Container for the Profile page content -->
        <div class="div_design">
            <!-- Title of the Profile page -->
            <h1 class="title_design">Profile</h1>

            <!-- Display Profile Picture -->
            <div class="field_design">
                <label>Profile Picture</label>
                @if($user->profile_photo_path)
                    <!-- If user has a profile photo, display it -->
                    <img class="profile-image" src="{{ asset($user->profile_photo_path) }}?{{ time() }}" alt="Profile Photo">
                @else
                    <!-- If no profile photo, show default image based on user type -->
                    @if($user->userType === 'admin')
                        <img class="profile-image" src="{{ asset('profileAdmin/defaultProfile.png') }}" alt="Admin Default Avatar">
                    @else
                        <img class="profile-image" src="{{ asset('profileUser/defaultProfile.png') }}" alt="User Default Avatar">
                    @endif
                @endif
            </div>

            <!-- Display User Information -->
            <div class="field_design">
                <label>Username</label>
                <!-- Display username -->
                <span class="field_value">{{ $user->name }}</span>
            </div>

            <div class="field_design">
                <label>Email</label>
                <!-- Display user email -->
                <span class="field_value">{{ $user->email }}</span>
            </div>

            <div class="field_design">
                <label>Phone Number</label>
                <!-- Display phone number if provided, otherwise show 'Not Provided' -->
                <span class="field_value">{{ $user->phone ?? 'Not Provided' }}</span>
            </div>

            <div class="field_design">
                <label>Password</label>
                <!-- Display placeholder for password -->
                <span class="field_value">********</span>
            </div>

            <!-- Button to navigate to the Edit Profile page -->
            <div class="field_design">
                <a href="{{ url('edit_profile') }}">
                    <!-- Edit button -->
                    <button class="btn_edit">Edit Profile</button>
                </a>
            </div>

        </div>

    </div>

    @include('home.footer')
</body>
</html>
