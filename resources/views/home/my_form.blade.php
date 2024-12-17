<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Basic styling -->
      <style type="text/css">

        /* Styling for each form post block */
        .post_design {
            padding: 30px;
            text-align: center;
            background-color: #06402B; /* Dark green background for the post block */
            margin-bottom: 20px;
            border-radius: 8px; /* Rounded corners for the block */
        }

        /* Styling for the title of the form */
        .title_design {
            color: white;
            font-weight: bold;
            padding: 15px;
            font-size: 30px; /* Large font size for form name */
        }

        /* Styling for the description and creator text */
        .p_design {
            color: whitesmoke; /* Slightly lighter color for text */
            font-weight: bold;
            padding: 15px;
            font-size: 17px; /* Standard font size for description */
        }

        /* Styling for the form image */
        .img_design {
            max-width: 100%; /* Image takes full width */
            max-height: 400px; /* Limit image height */
            width: auto;
            height: auto;
            display: block;
            margin: auto; /* Centers the image */
        }

        /* Container for action buttons */
        .btn-container {
            margin-top: 15px;
        }

        /* Styling for the status labels */
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

        @include('home.homecss') <!-- Include external CSS for global styles -->
   </head>
   <body>
      <!-- header section start -->
      <div class="header_section">
        @include('home.header') <!-- Include the header (navigation bar) -->

        <!-- Display confirmation message if set -->
        @if(session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                {{session()->get('message')}}
            </div>
        @endif

        <!-- Loop through all forms and display them -->
        @foreach($forms as $form)
            <div class="post_design">
                <!-- Display form image if available, else display default image -->
                <img class="img_design" src="/formImage/{{$form->image ?? 'defaultForm.png'}}" alt="Form Image">

                <!-- Display the form name -->
                <h3 class="title_design">{{$form->name}}</h3> 

                <!-- Display the form description -->
                <p class="p_design">{{$form->description}}</p> 

                <!-- Display the creator of the form -->
                <p class="p_design"><b>Created By:</b> {{$form->creator}}</p>

                <!-- Display the status of the form with color coding -->
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

                <!-- Buttons for deleting and updating the form -->
                <div class="btn-container">
                    <!-- Delete button with confirmation prompt -->
                    <a onclick="return confirm('Are you sure you want to delete this form?')" href="{{url('deleteForm', $form->id)}}" class="btn btn-danger">Delete</a>
                    
                    <!-- Update button to modify the form -->
                    <a href="{{url('update_user_form', $form->id)}}" class="btn btn-primary">Update</a>
                </div>
            </div>
        @endforeach
        <!-- End form display -->

      </div>

      <!-- Include footer -->
      @include('home.footer')
   </body>
</html>
