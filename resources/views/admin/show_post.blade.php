<!DOCTYPE html>
<html>
  <head> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" 
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @include('admin.css')

    <style type="text/css">
        .title_design {
            font-size: 30px;
            font-weight: bold;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .table_design {
            width: 95%;
            margin: 0 auto;
            border-collapse: collapse;
            border: 1px solid white;
            text-align: center;
        }

        .table_design th, .table_design td {
            padding: 15px;
            border: 1px solid #dddddd;
            vertical-align: middle;
        }

        .table_design td {
            word-wrap: break-word;
        }

        .tHeader_design {
            background-color: skyblue;
        }

        .table_design tr {
            transition: background-color 0.5s ease;
        }

        .table_design tr:hover {
            background-color: #e9ecef;
        }

        .title_column {
            width: 20%;
        }

        .description_column {
            width: 35%;
            text-align: left;
        }

        .posted_by_column,
        .status_column,
        .user_column {
            width: 10%;
        }

        .img_column {
            width: 10%;
        }

        .btn {
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-danger {
            background-color: red;
            color: white;
        }

        .btn-danger:hover {
            background-color: darkred;
        }

        .btn-success {
            background-color: green;
            color: white;
        }

        .btn-success:hover {
            background-color: darkgreen;
        }

        .btn-outline-secondary {
            background-color: gray;
            color: white;
        }

        .btn-outline-secondary:hover {
            background-color: darkgray;
        }

        .btn-primary {
            background-color: blue;
            color: white;
        }

        .btn-primary:hover {
            background-color: darkblue;
        }

        .img_design {
            height: 100px;
            width: 100px;
            padding: 10px;
            object-fit: cover;
        }
    </style>

  </head>
  <body>
    @include('admin.header')
    <div class="d-flex align-items-stretch">
      @include('admin.sidebar')

      <div class="page-content">

        @if(session()->has('message'))
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
            {{ session()->get('message') }}
          </div>
        @endif

        <h1 class="title_design">All Posts</h1>
        <table class="table_design">
          <tr class="tHeader_design">
            <th class="title_column">Post Title</th>
            <th class="description_column">Description</th>
            <th class="posted_by_column">Posted By</th>
            <th class="status_column">Post Status</th>
            <th class="user_column">User</th>
            <th class="img_column">Thumbnail</th>
            <th>Delete Post</th>
            <th>Edit Post</th>
            <th>Status Accept</th>
            <th>Status Reject</th>
          </tr>
          @foreach($posts as $post)
            <tr>
              <td class="title_column">{{ $post->title }}</td>
              <td class="description_column">{{ $post->description }}</td>
              <td class="posted_by_column">{{ $post->name }}</td>
              <td class="status_column">{{ $post->post_status }}</td>
              <td class="user_column">{{ $post->userType }}</td>
<td class="img_column">
    @if($post->video_link)
        @if(!empty($post->image) && file_exists(public_path('postimage/' . $post->image)))
            <!-- If there's a video link and an uploaded image, use the uploaded image -->
            <img class="img_design" src="{{ asset('postimage/' . $post->image) }}" alt="Uploaded Image">
        @else
            <!-- If there's a video link but no uploaded image or the image is missing, use the YouTube thumbnail -->
            <img class="img_design" src="{{ $post->thumbnail }}" alt="YouTube Thumbnail">
        @endif
    @elseif(!empty($post->image) && file_exists(public_path('postimage/' . $post->image)))
        <!-- If there's no video link but an image is uploaded and the file exists, use the uploaded image -->
        <img class="img_design" src="{{ asset('postimage/' . $post->image) }}" alt="Uploaded Image">
    @else
        <!-- If neither a video link nor an image is uploaded or both are missing, use the default thumbnail -->
        <img class="img_design" src="{{ asset('defaultThumbnail/defaultThumbnail.jpg') }}" alt="Default Thumbnail">
    @endif
</td>



              <td>
                <a href="{{ url('delete_post', $post->id) }}" class="btn btn-danger" onclick="confirmation(event)">Delete</a>
              </td>
              <td>
                <a href="{{ url('edit_post', $post->id) }}" class="btn btn-success">Edit</a>
              </td>
              <td>
                <a onclick="return confirm('Are you sure to accept this post?')" href="{{ url('accept_post', $post->id) }}" class="btn btn-outline-secondary">Accept</a>
              </td>
              <td>
                <a onclick="return confirm('Are you sure to reject this post?')" href="{{ url('reject_post', $post->id) }}" class="btn btn-primary">Reject</a>
              </td>
            </tr>
          @endforeach
        </table>
      </div>
    </div>

    @include('admin.footer')

    <script type="text/javascript">
      function confirmation(ev) {
        ev.preventDefault();
        var urlToRedirect = ev.currentTarget.getAttribute('href');
        swal({
          title: "Are you sure to delete this post?", 
          text: "You won't be able to revert this deletion", 
          icon: "warning",
          buttons: true,
          dangerMode: true
        }).then((willCancel) => {
          if (willCancel) {
            window.location.href = urlToRedirect;
          }
        });
      }
    </script>
  </body>
</html>
