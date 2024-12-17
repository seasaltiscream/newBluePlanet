<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .div_design {
            text-align: center;
            padding: 30px;
            background-color: #000000; /* Black background */
        }
        .title_design {
            font-size: 30px;
            font-weight: bold;
            color: white;
            padding: 30px;
        }
        label {
            display: inline-block;
            width: 200px;
            color: white;
            font-size: 18px;
            font-weight: bold;
        }
        .field_value {
            display: inline-block;
            width: 300px;
            color: lightgray;
            font-size: 18px;
            text-align: left;
        }
        .btn_edit {
            padding: 10px 20px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn_edit:hover {
            background-color: #4cae4c;
        }
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }
    </style>
    @include('home.homecss')
</head>
<body>
    
    <div class="header_section">
        @include('home.header')

        <div class="div_design">
            <h1 class="title_design">Profile</h1>

            <!-- Display Profile Picture -->
            <!-- Display Profile Picture -->
            <div class="field_design">
                <label>Profile Picture</label>
                @if($user->profile_photo_path)
                    <!-- Corrected path to profile photo -->
                    <img class="profile-image" src="{{ asset($user->profile_photo_path) }}?{{ time() }}" alt="Profile Photo">
                @else
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
                <span class="field_value">{{ $user->name }}</span>
            </div>

            <div class="field_design">
                <label>Email</label>
                <span class="field_value">{{ $user->email }}</span>
            </div>

            <div class="field_design">
                <label>Phone Number</label>
                <span class="field_value">{{ $user->phone ?? 'Not Provided' }}</span>
            </div>

            <div class="field_design">
                <label>Password</label>
                <span class="field_value">********</span>
            </div>

            <div class="field_design">
                <a href="{{ url('edit_profile') }}">
                    <button class="btn_edit">Edit Profile</button>
                </a>
            </div>
        </div>

    </div>

    @include('home.footer')
</body>
</html>
