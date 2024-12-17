<!DOCTYPE html>
<html>
  <head>
    <!-- Include SweetAlert library for confirmation popups -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" 
      integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" 
      crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Include the admin CSS styles -->
    @include('admin.css')

    <style type="text/css">
      /* Custom style for the page title */
      .title_design {
        font-size: 30px;  /* Larger text size for the title */
        font-weight: bold; /* Bold text */
        color: white; /* White color for text */
        padding: 30px; /* Padding for spacing */
        text-align: center; /* Center the title */
      }

      /* Style for the table displaying the posts */
      .table_design {
        width: 95%; /* Set table width */
        margin: 0 auto; /* Center the table horizontally */
        border-collapse: collapse; /* Collapse borders between cells */
        border: 1px solid white; /* White border around table */
        text-align: center; /* Center-align text within table cells */
      }

      /* Styling for table header and cells */
      .table_design th, .table_design td {
        padding: 15px; /* Add padding inside cells */
        border: 1px solid #dddddd; /* Light gray border for cells */
        vertical-align: middle; /* Align content vertically in the middle */
      }

      /* Allow long content in table cells to break and wrap onto new lines */
      .table_design td {
        word-wrap: break-word;
      }

      /* Custom background for the header row */
      .tHeader_design {
        background-color: skyblue; /* Light blue background */
      }

      /* Hover effect for table rows */
      .table_design tr {
        transition: background-color 0.5s ease; /* Smooth background transition */
      }

      .table_design tr:hover {
        background-color: #e9ecef; /* Change background color on hover */
      }

      /* Column widths */
      .title_column {
        width: 20%; /* Set width for title column */
      }

      .description_column {
        width: 35%; /* Set width for description column */
        text-align: left; /* Align description text to the left */
      }

      .posted_by_column, .status_column, .user_column {
        width: 10%; /* Set width for these columns */
      }

      .img_column {
        width: 10%; /* Set width for image column */
      }

      /* Button styling */
      .btn {
        padding: 8px 12px; /* Padding inside buttons */
        border-radius: 5px; /* Rounded corners */
        text-decoration: none; /* Remove underline from buttons */
      }

      /* Danger button (red) for delete actions */
      .btn-danger {
        background-color: red; /* Red background */
        color: white; /* White text */
      }

      .btn-danger:hover {
        background-color: darkred; /* Dark red on hover */
      }

      /* Success button (green) for editing actions */
      .btn-success {
        background-color: green; /* Green background */
        color: white; /* White text */
      }

      .btn-success:hover {
        background-color: darkgreen; /* Dark green on hover */
      }

      /* Secondary button (gray) for confirmation actions */
      .btn-outline-secondary {
        background-color: gray; /* Gray background */
        color: white; /* White text */
      }

      .btn-outline-secondary:hover {
        background-color: darkgray; /* Dark gray on hover */
      }

      /* Primary button (blue) for accepting actions */
      .btn-primary {
        background-color: blue; /* Blue background */
        color: white; /* White text */
      }

      .btn-primary:hover {
        background-color: darkblue; /* Dark blue on hover */
      }

      /* Image styling for thumbnails */
      .img_design {
        height: 100px; /* Set image height */
        width: 100px; /* Set image width */
        padding: 10px; /* Add padding around images */
        object-fit: cover; /* Ensure the image covers the area */
      }
    </style>

  </head>
  <body>
    <!-- Include the admin header -->
    @include('admin.header')

    <div class="d-flex align-items-stretch">
      <!-- Include the admin sidebar for navigation -->
      @include('admin.sidebar')

      <div class="page-content">
        <!-- Display success or error messages from session -->
        @if(session()->has('message'))
          <div class="alert alert-danger">
            <!-- Close button for the alert -->
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
            {{ session()->get('message') }} <!-- Display message -->
          </div>
        @endif

        <!-- Page title -->
        <h1 class="title_design">All Posts</h1>

        <!-- Table for displaying posts -->
        <table class="table_design">
          <!-- Table header row -->
          <tr class="tHeader_design">
            <th class="title_column">Post Title</th> <!-- Column for post titles -->
            <th class="description_column">Description</th> <!-- Column for descriptions -->
            <th class="posted_by_column">Posted By</th> <!-- Column for creator's name -->
            <th class="status_column">Post Status</th> <!-- Column for post status -->
            <th class="user_column">User</th> <!-- Column for user type (Admin/Regular) -->
            <th class="img_column">Thumbnail</th> <!-- Column for post thumbnail -->
            <th>Delete Post</th> <!-- Button to delete a post -->
            <th>Edit Post</th> <!-- Button to edit a post -->
            <th>Status Accept</th> <!-- Button to accept the post -->
            <th>Status Reject</th> <!-- Button to reject the post -->
          </tr>

          <!-- Loop through each post and display its details -->
          @foreach($posts as $post)
            <tr>
              <!-- Display post title -->
              <td class="title_column">{{ $post->title }}</td>
              <!-- Display post description -->
              <td class="description_column">{{ $post->description }}</td>
              <!-- Display the name of the person who posted -->
              <td class="posted_by_column">{{ $post->name }}</td>
              <!-- Display the post's current status -->
              <td class="status_column">{{ $post->post_status }}</td>
              <!-- Display the type of user (admin or regular) -->
              <td class="user_column">{{ $post->userType }}</td>

              <!-- Display the thumbnail -->
              <td class="img_column">
                @if($post->video_link)
                  <!-- If there's a video link, display the thumbnail from YouTube or uploaded image -->
                  @if(!empty($post->image) && file_exists(public_path('postimage/' . $post->image)))
                    <img class="img_design" src="{{ asset('postimage/' . $post->image) }}" alt="Uploaded Image">
                  @else
                    <img class="img_design" src="{{ $post->thumbnail }}" alt="YouTube Thumbnail">
                  @endif
                @elseif(!empty($post->image) && file_exists(public_path('postimage/' . $post->image)))
                  <!-- If no video but image exists, display the uploaded image -->
                  <img class="img_design" src="{{ asset('postimage/' . $post->image) }}" alt="Uploaded Image">
                @else
                  <!-- If neither a video nor image exists, display default thumbnail -->
                  <img class="img_design" src="{{ asset('defaultThumbnail/defaultThumbnail.jpg') }}" alt="Default Thumbnail">
                @endif
              </td>

              <!-- Delete button with confirmation -->
              <td>
                <a href="{{ url('delete_post', $post->id) }}" class="btn btn-danger" onclick="confirmation(event)">Delete</a>
              </td>
              <!-- Edit button to open edit form for the post -->
              <td>
                <a href="{{ url('edit_post', $post->id) }}" class="btn btn-success">Edit</a>
              </td>
              <!-- Accept button to approve the post -->
              <td>
                <a onclick="return confirm('Are you sure to accept this post?')" href="{{ url('accept_post', $post->id) }}" class="btn btn-outline-secondary">Accept</a>
              </td>
              <!-- Reject button to reject the post -->
              <td>
                <a onclick="return confirm('Are you sure to reject this post?')" href="{{ url('reject_post', $post->id) }}" class="btn btn-primary">Reject</a>
              </td>
            </tr>
          @endforeach
        </table>
      </div>
    </div>

    <!-- Include the admin footer -->
    @include('admin.footer')

    <!-- JavaScript function for confirming post deletion -->
    <script type="text/javascript">
      function confirmation(ev) {
        ev.preventDefault();  // Prevent the default action (delete)
        var urlToRedirect = ev.currentTarget.getAttribute('href');  // Get the URL for deletion
        swal({
          title: "Are you sure to delete this post?",  // Alert message
          text: "You won't be able to revert this deletion",  // Additional warning text
          icon: "warning",  // Icon for the alert
          buttons: true,  // Show the action buttons
          dangerMode: true  // Red color for danger button
        }).then((willCancel) => {
          if (willCancel) {
            window.location.href = urlToRedirect;  // Redirect to the delete URL if confirmed
          }
        });
      }
    </script>
  </body>
</html>
