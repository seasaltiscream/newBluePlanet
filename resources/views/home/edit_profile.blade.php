<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .div_design {
            text-align: center;
            padding: 30px;
            background-color: #1d1d1d; /* Dark background for better contrast */
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
        .field_design {
            padding: 15px;
        }
        .field_design input {
            padding: 10px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
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
    @include('home.header')

    <div class="div_design">
        <h1 class="title_design">Edit Profile</h1>
        <form action="{{ url('update_profile') }}" method="POST" enctype="multipart/form-data">
            @csrf

        <!-- Display Profile Picture -->
        <div class="field_design">
            <label>Profile Picture</label>
            @if($user->profile_photo_path)
                <img class="profile-image" src="{{ asset($user->profile_photo_path) }}" alt="Profile Photo">
            @else
                @if($user->userType === 'admin')
                    <img class="profile-image" src="{{ asset('profileAdmin/defaultProfile.png') }}" alt="Admin Default Avatar">
                @else
                    <img class="profile-image" src="{{ asset('profileUser/defaultProfile.png') }}" alt="User Default Avatar">
                @endif
            @endif
            <input type="file" name="profile_photo" accept="image/*">
        </div>


            <!-- Username -->
            <div class="field_design">
                <label>Username</label>
                <input type="text" name="username" value="{{ $user->name }}" required>
            </div>

            <!-- Email -->
            <div class="field_design">
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required>
            </div>

            <!-- Phone Number -->
            <div class="field_design">
                <label>Phone Number</label>
                <input type="text" name="phone" value="{{ $user->phone ?? '' }}" placeholder="Enter phone number (optional)">
            </div>

            <!-- Password -->
            <div class="field_design">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter new password (optional)">
            </div>

            <!-- Save Button -->
            <div class="field_design">
                <input type="submit" value="Save Changes" class="btn_save">
            </div>
        </form>
    </div>

    @include('home.footer')
</body>
</html>
