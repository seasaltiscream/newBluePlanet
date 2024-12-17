<!-- Volunteer Forms Section -->
<!-- This section displays a list of volunteer forms available to users. -->
<div class="services_section layout_padding">
    <div class="container bg-light">
        <!-- Section Title -->
        <h1 class="services_taital">Volunteer Forms</h1>
        <div class="services_section_2">
            <div class="row">
                <!-- Loop through the list of available forms -->
                @foreach($forms as $form)
                    <div class="col-md-4 mb-4">
                        <div class="card" style="width: 100%;">

                            <!-- Check if the form has an image -->
                            @if($form->image)
                                <!-- Display the form image if it exists -->
                                <img src="{{ asset('formImage/' . $form->image) }}" class="card-img-top" alt="Form Image" style="height: 200px; object-fit: cover;">
                            @else
                                <!-- If no image exists, display a default image -->
                                <img src="{{ asset('defaultForm.png') }}" class="card-img-top" alt="Default Form Image" style="height: 200px; object-fit: cover;">
                            @endif

                            <!-- Card Body Section -->
                            <div class="card-body">
                                <!-- Display the form name -->
                                <h4 class="card-title">{{ $form->name }}</h4>
                                
                                <!-- Display the form description -->
                                <p class="card-text">{{ $form->description }}</p>
                                
                                <!-- Display the form creator's name -->
                                <p class="card-text"><b>Created By:</b> {{ $form->creator }}</p>
                                
                                <!-- Link to view the form. Opens in a new tab -->
                                <a href="{{ $form->link }}" class="btn btn-primary" target="_blank">View Form</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- End of Loop through Volunteer Forms -->
            </div>
        </div>
    </div>
</div>
<!-- End of Volunteer Forms Section -->
