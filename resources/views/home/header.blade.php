<!-- This whole section is the main header structure -->
<div class="header_main">

    <!-- Mobile Menu for responsive design (Hamburger menu for smaller screens) -->
    <div class="mobile_menu">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!-- Mobile Logo: A clickable logo that links to the homepage -->
            <div class="logo_mobile">
                <a href="index.html"><img src="images/logo.png"></a> <!-- Modify the 'href' to your homepage URL -->
            </div>

            <!-- Toggle Button: For collapsing the menu when the screen is small -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible Navigation Links: These links show when the mobile menu is expanded -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Home Link: Directs to the homepage -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a> <!-- Modify the 'href' to match your homepage route -->
                    </li>
                    <!-- About Link: Directs to the About page -->
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a> <!-- Modify the 'href' to match your About page -->
                    </li>
                    <!-- Volunteer Link: Directs to the Volunteer page -->
                    <li class="nav-item">
                        <a class="nav-link" href="services.html">Volunteer</a> <!-- Modify the 'href' to match your Volunteer page -->
                    </li>
                    <!-- Blog Link: Directs to the Blog page -->
                    <li class="nav-item">
                        <a class="nav-link" href="blog.html">Blog</a> <!-- Modify the 'href' to match your Blog page -->
                    </li>
                    <!-- Contact Link: Directs to the Contact page -->
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact</a> <!-- Modify the 'href' to match your Contact page -->
                    </li>
                    <!-- Additional buttons: You can add other buttons here -->
                </ul>
            </div>
        </nav>
    </div>

    <!-- Original Header (Standard View for Larger Screens) -->
    <div class="container-fluid">
        <!-- Main Logo: A clickable logo that links to the homepage -->
        <div class="logo">
            <div class="fs-1">
                <a class="text-white" href="{{ url('/') }}">Blue Planet</a> <!-- Modify the 'href' to your homepage route -->
            </div>
        </div>

        <!-- Main Menu: The primary navigation links -->
        <div class="menu_main">
            <ul>
                <!-- Home Link: Directs to the homepage -->
                <li class="active"><a href="{{ url('/') }}">Home</a> <!-- Modify the 'href' to match your homepage route -->
                </li>

                <!-- About Us Link: Directs to the About Us page -->
                <li><a href="{{ url('about_us') }}">About</a> <!-- Modify the 'href' to match your About Us page -->
                </li>

                <!-- Blog Link: Directs to the Blog page -->
                <li><a href="{{ url('blog_posts') }}">Blog</a> <!-- Modify the 'href' to match your Blog page -->
                </li>

                <!-- Volunteer Link: Directs to the Volunteer page -->
                <li><a href="{{ url('volunteer_posts') }}">Volunteer</a> <!-- Modify the 'href' to match your Volunteer page -->
                </li>

                <!-- Authentication Links: For logged-in users and those not logged in -->
                @if (Route::has('login')) <!-- Ensures login links are shown based on authentication status -->
                    @auth <!-- Shows this section if the user is authenticated -->
                        <!-- User-specific options (only visible when logged in) -->
                        <li>
                            <x-app-layout></x-app-layout> <!-- This is a Laravel Blade component for authenticated users' dashboard or navigation -->
                        </li>
                        <!-- My Post Link: Directs to the user's own posts -->
                        <li><a href="{{ url('my_post') }}">My Post</a> <!-- Modify the 'href' to match the route for the user's posts -->
                        </li>

                        <!-- Create Post Link: Directs to the page where the user can create new posts -->
                        <li><a href="{{ url('create_post') }}">Create Post</a> <!-- Modify the 'href' to match the route for creating posts -->
                        </li>

                        <!-- My Form Link: Directs to the user's own forms -->
                        <li><a href="{{ url('my_form') }}">My Form</a> <!-- Modify the 'href' to match the route for the user's forms -->
                        </li>

                        <!-- Create Form Link: Directs to the page where the user can create new forms -->
                        <li><a href="{{ url('create_form') }}">Create Form</a> <!-- Modify the 'href' to match the route for creating forms -->
                        </li>

                        <!-- User Profile Link: Directs to the user's profile page -->
                        <li><a href="{{ url('user_profile') }}">Profile</a> <!-- Modify the 'href' to match the route for the user's profile -->
                        </li>
                    @else <!-- Shows this section if the user is not authenticated -->
                        <!-- Login Link: Directs to the login page -->
                        <li><a href="{{ route('login') }}">Login</a> <!-- Modify the 'href' to match the login route -->
                        </li>

                        <!-- Register Link: Directs to the registration page -->
                        <li><a href="{{ route('register') }}">Register</a> <!-- Modify the 'href' to match the register route -->
                        </li>
                    @endauth
                @endif

                <!-- Optional Dropdowns: Suggested to organize some links -->
                <!-- Dropdown for "Post": This will include links for viewing, creating, and managing posts -->
                <!-- Dropdown for "Form": This will include links for viewing, creating, and managing forms -->
                <!-- You can implement these dropdowns using <li> with nested <ul> tags for better organization -->
            </ul>
        </div>
    </div>
</div>

