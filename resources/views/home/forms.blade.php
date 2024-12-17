<!-- list of the forms available/active -->
<div class="services_section layout_padding">
    <div class="container bg-light">
        <h1 class="services_taital">Volunteer Forms</h1>
        <div class="services_section_2">
            <div class="row">
                <!-- Loop through volunteer forms -->
                @foreach($forms as $form)
                <div class="col-md-4 mb-4">
                    <div class="card" style="width: 100%;">
                        <!-- Display form image if it exists, otherwise show a default image -->
                        @if($form->image)
                                    <img src="{{ asset('formImage/' . $form->image) }}" class="card-img-top" alt="Form Image" style="height: 200px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('defaultForm.png') }}" class="card-img-top" alt="Default Form Image" style="height: 200px; object-fit: cover;">
                                @endif
                        <div class="card-body">
                            <h4 class="card-title">{{ $form->name }}</h4>
                            <p class="card-text">{{ $form->description }}</p>
                            <p class="card-text"><b>Created By:</b> {{ $form->creator }}</p>
                            <a href="{{ $form->link }}" class="btn btn-primary" target="_blank">View Form</a>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- Loop through volunteer forms -->
            </div>
        </div>
    </div>
</div>
<!-- list of the forms available/active -->
