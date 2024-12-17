<!DOCTYPE html>
<html>
<head>
    <base href="/public">
    @include('admin.css')

    <style type="text/css">
        .edit_profile_title {
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            padding: 30px;
            color: white;
        }

        .div_center {
            text-align: center;
            padding: 30px;
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

        .alert {
            color: green;
            text-align: center;
            padding: 10px;
            background-color: #e8f7e8;
        }

        .alert-danger {
            color: red;
            background-color: #f8d7da;
        }

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

        .btn_edit:hover {
            background-color: #34495e;
        }

        .field_design {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 10px 0;
        }

        .profile_container {
            background-color: #34495e;
            padding: 30px;
            border-radius: 10px;
            margin-left: 250px;
            width: calc(100% - 250px);
        }

        .profile-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

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
    @include('admin.header')

    <div class="d-flex align-items-stretch">
        @include('admin.sidebar')

        <div class="page-content">
            <div class="profile_container">
                <h1 class="edit_profile_title">Edit Admin Profile</h1>

                @if(session('message'))
                    <div class="alert">{{ session('message') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('updateAdmin') }}" method="POST" enctype="multipart/form-data" class="profile-form">
                    @csrf

                    <div class="field_design">
                        <label>Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->name) }}">
                    </div>

                    <div class="field_design">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}">
                    </div>

                    <div class="field_design">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}">
                    </div>

                    <div class="field_design">
                        <label>New Password</label>
                        <input type="password" name="password">
                    </div>

                    <div class="field_design">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation">
                    </div>

                    <div class="field_design">
                        <label>Profile Picture</label>
                        @if($user->profile_photo_path)
                            <img class="profile-image" src="{{ asset($user->profile_photo_path) }}" alt="Profile Photo">
                        @else
                            <img class="profile-image" src="{{ asset('profileAdmin/defaultProfile.png') }}" alt="Default Avatar">
                        @endif
                        <br>
                        <label>Update Profile Picture</label>
                        <input type="file" name="profile_photo">
                    </div>

                    <div class="field_design">
                        <input type="submit" value="Update Profile" class="btn_edit">
                    </div>
                </form>

            </div>
        </div>
    </div>    

    @include('admin.footer')
</body>
</html>
