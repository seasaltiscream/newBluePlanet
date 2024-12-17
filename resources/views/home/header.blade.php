
<!-- This whole section I have 0 clue what it doing here -->
<div class="header_main">


            <!-- so this is basically the haburger menu thingy when u make ur web smaller (try inspect to see what I mean) -->
            <div class="mobile_menu">
               <nav class="navbar navbar-expand-lg navbar-light bg-light">
                  <div class="logo_mobile"><a href="index.html"><img src="images/logo.png"></a></div>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNav">
                     <ul class="navbar-nav">
                        <li class="nav-item">
                           <a class="nav-link" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="about.html">About</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="services.html">Volunteer</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link " href="blog.html">Blog</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link " href="contact.html">Contact</a>
                        </li>
                        <!-- as for the buttons, I havent followed the og one so if ur not bothered, tambahin dong (just copas and make sure the href is correct) -->
                     </ul>
                  </div>
               </nav>
            </div>

            <!-- the OG header -->
            <div class="container-fluid">
               <div class="logo">
                  <div class="fs-1">
                     <a class= "text-white " href="{{ url('/') }}">Blue Planet</a>
                  </div>
               </div>

                <!-- basically the things at the header -->
               <div class="menu_main">
                  <ul>
                     <li class="active"><a href="{{ url('/') }}">Home</a></li>
                     <li><a href="{{ url('about_us') }}">About</a></li>
                      <li><a href="{{ url('blog_posts') }}">Blog</a></li>
                     <li><a href="{{ url('volunteer_posts') }}">Volunteer</a></li>
                     @if (Route::has('login'))
                     @auth
                     <li>
                     <x-app-layout>
                     </x-app-layout>
                     </li>
                     <!-- idk what does x app layout do but it has something to do with AppLayout.php at view\components -->

                     <li><a href="{{url('my_post')}}">My Post</a></li>
                     <li><a href="{{url('create_post')}}">Create Post</a></li>
                     <li><a href="{{url('my_form')}}">My Form</a></li>
                     <li><a href="{{url('create_form')}}">Create Form</a></li>
                     <li><a href="{{ url('user_profile') }}">Profile</a></li>
                     @else
                     <li><a href="{{route('login')}}">Login</a></li>
                     <li><a href="{{route('register')}}">Register</a></li>
                     @endauth
                     @endif
                     <!-- if u think its a struggle to make all the buttons there, I think u can make 2 dropdowns -->
                     <!-- 1st dropdown, Post (childs: view all posts, my posts, make posts) -->
                     <!-- 2nd dropdown, form (childs: view all form, my form, make form) -->
                     <!-- pls make sure that the @ shits not scattered somewhere else -->


                  </ul>
               </div>
               <!-- basically the things at the header -->

            </div>
         </div>