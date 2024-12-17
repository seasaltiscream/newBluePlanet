

<!-- a page for u to see your forms (whether its active, pending, or rejected) -->

<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Basic styling -->
      <style type="text/css">

        .post_design {
            padding: 30px;
            text-align: center;
            background-color: #06402B;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .title_design {
            color: white;
            font-weight: bold;
            padding: 15px;
            font-size: 30px;
        }

        .p_design {
            color: whitesmoke;
            font-weight: bold;
            padding: 15px;
            font-size: 17px;
        }

        .img_design {
            max-width: 100%;
            max-height: 400px;
            width: auto;
            height: auto;
            display: block;
            margin: auto;
        }

        .btn-container {
            margin-top: 15px;
        }

        .btn-container a {
            margin-right: 10px;
        }

        .status_pending {
            background-color: orange;
            padding: 5px 10px;
            color: white;
            font-weight: bold;
        }

        .status_active {
            background-color: green;
            padding: 5px 10px;
            color: white;
            font-weight: bold;
        }

        .status_rejected {
            background-color: red;
            padding: 5px 10px;
            color: white;
            font-weight: bold;
        }

       </style>

        @include('home.homecss')
   </head>
   <body>
      <!-- header section start -->
      <div class="header_section">
        @include('home.header')

        <!-- Confirmation message -->
        @if(session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                {{session()->get('message')}}
            </div>
        @endif

        <!-- Displaying forms -->
        @foreach($forms as $form)
            <div class="post_design">
                <!-- Display image if available -->
                <img class="img_design" src="/formImage/{{$form->image ?? 'defaultForm.png'}}" alt="Form Image">

                <h3 class="title_design">{{$form->name}}</h3> <!-- Display form name -->
                <p class="p_design">{{$form->description}}</p> <!-- Display form description -->
                <p class="p_design"><b>Created By:</b> {{$form->creator}}</p> <!-- Display creator -->

                <!-- Display status with color coding -->
                <p class="p_design">
                    <b>Status:</b> 
                    @if($form->status == 'pending')
                        <span class="status_pending">Pending</span>
                    @elseif($form->status == 'active')
                        <span class="status_active">Active</span>
                    @elseif($form->status == 'rejected')
                        <span class="status_rejected">Rejected</span>
                    @else
                        <span>{{$form->status}}</span>
                    @endif
                </p>

                <!-- Buttons for updating and deleting the form -->
                <div class="btn-container">
                    <a onclick="return confirm('Are you sure you want to delete this form?')" href="{{url('deleteForm', $form->id)}}" class="btn btn-danger">Delete</a>
                    <a href="{{url('update_user_form', $form->id)}}" class="btn btn-primary">Update</a>
                </div>
            </div>
        @endforeach
        <!-- End form display -->

      </div>

      @include('home.footer')
   </body>
</html>
