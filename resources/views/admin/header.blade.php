<header class="header">   
    <nav class="navbar navbar-expand-lg">
        <div class="search-panel">
            <div class="search-inner d-flex align-items-center justify-content-center">
                <div class="close-btn">Close <i class="fa fa-close"></i></div>
                <form id="searchForm" action="#">
                    <div class="form-group">
                        <input type="search" name="search" placeholder="What are you searching for...">
                        <button type="submit" class="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="navbar-header">
                <div class="brand-text brand-sm"><strong class="text-primary">D</strong><strong>A</strong></div> 
            </div>

            <!-- Profile Button and Admin Profile Link -->
            <div class="list-inline-item logout">
                <x-app-layout></x-app-layout>
                <!-- Add Button to Redirect to Admin Profile -->
                <a href="{{ url('admin_profile') }}" class="btn btn-primary">Go to Admin Profile</a>
            </div>
        </div>
    </nav>
</header>



<!-- ur typical header but I honestly forgot how it works, just experiment it -->