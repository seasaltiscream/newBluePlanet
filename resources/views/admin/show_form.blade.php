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

      .creator_column,
      .link_column,
      .status_column {
        width: 15%;
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

      .link-column a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
      }

      .link-column a:hover {
        text-decoration: underline;
        color: #0056b3;
      }
    </style>
  </head>

  <body>
    @include('admin.header')

    <div class="d-flex align-items-stretch">
      @include('admin.sidebar')

      <div class="page-content">
        @if(session()->has('message'))
          <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
            {{ session()->get('message') }}
          </div>
        @endif

        <h1 class="title_design">All Forms</h1>

        <table class="table_design">
          <tr class="tHeader_design">
            <th class="title_column">Form Title</th>
            <th class="description_column">Description</th>
            <th class="creator_column">Creator</th>
            <th class="link_column">Link</th>
            <th class="status_column">Status</th>
            <th class="img_column">Image</th>
            <th>Delete Form</th>
            <th>Edit Form</th>
            <th>Status Accept</th>
            <th>Status Reject</th>
            <th>Reset Image</th>
          </tr>

          @foreach($forms as $form)
            <tr>
              <td class="title_column">{{ $form->name }}</td>
              <td class="description_column">{{ $form->description }}</td>
              <td class="creator_column">{{ $form->creator }}</td>
              <td class="link_column">
                <a href="{{ $form->link }}" target="_blank" class="btn-link">{{ $form->link }}</a>
              </td>
              <td class="status_column">{{ $form->status }}</td>
              <td class="img_column">
                  @if($form->image && file_exists(public_path('formImage/' . $form->image)))
                      <img class="img-design" src="{{ asset('formImage/' . $form->image) }}" style="height: 100px; width: 100px; object-fit: cover;">
                  @else
                      <img class="img-design" src="{{ asset('formImage/defaultForm.png') }}" style="height: 100px; width: 100px; object-fit: cover;">
                  @endif
              </td>

              <td>
                <a href="{{ url('delete_form', $form->id) }}" class="btn btn-danger" onclick="confirmation(event)">Delete</a>
              </td>
              <td>
                <a href="{{ url('edit_form_page', $form->id) }}" class="btn btn-success">Edit</a>
              </td>
              <td>
                <a onclick="return confirm('Are you sure to accept this form?')" href="{{ url('accept_form', $form->id) }}" class="btn btn-outline-secondary">Accept</a>
              </td>
              <td>
                <a onclick="return confirm('Are you sure to reject this form?')" href="{{ url('reject_form', $form->id) }}" class="btn btn-primary">Reject</a>
              </td>
              <td>
                <a onclick="return confirm('Are you sure to reset this form\'s image to default?')" href="{{ url('resetFormImage', $form->id) }}" class="btn btn-warning">Reset Image</a>
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
          title: "Are you sure to delete this form?", 
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
