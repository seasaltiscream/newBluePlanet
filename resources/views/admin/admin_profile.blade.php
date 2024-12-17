{{-- resources/views/admin/profile.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <base href="/public">
    @include('admin.css')

    <style type="text/css">
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
    @include('admin.header')

    <div class="d-flex align-items-stretch">
        @include('admin.sidebar')

        <div class="page-content">
            <!-- @if($user->profile_photo_path)
                <img class="profile-image" src="{{ asset($user->profile_photo_path) }}" alt="Profile Photo">
            @else
                <img class="profile-image" src="{{ asset('public/profileAdmin/defaultProfile.png') }}" alt="Admin Default Avatar">
            @endif -->


            <div class="profile_container">
                <h1 class="title_design">Admin Profile</h1>

                <!-- Admin Profile Info -->
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
                    <label>Role</label>
                    <span class="field_value">Admin</span>
                </div>

                <!-- <div class="field_design">
                    <label>Joined on</label>
                    <span class="field_value">{{ $user->created_at->format('d M, Y') }}</span>
                </div> -->

                <!-- Profile Picture -->
                <!-- {{-- Profile picture rendering logic based on user type --}} -->
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
                </div>



                <!-- Password field displayed as **** -->
                <div class="field_design">
                    <label>Password</label>
                    <span class="field_value">****</span>  <!-- Hide password as **** -->
                </div>

                <!-- Edit Profile Button -->
                <div class="field_design">
                    <a href="{{ url('edit_admin') }}" class="btn_edit">Edit Profile</a>
                </div>

            </div>
        </div>
    </div>

    @include('admin.footer')
</body>
</html>
