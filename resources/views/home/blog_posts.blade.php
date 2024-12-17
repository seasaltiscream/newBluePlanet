

<!-- blog posts, following the usual layout -->
 <!-- if u wanna edit the blog posts section itself, its at services.blade.php -->


<!DOCTYPE html>
<html lang="en">
   <head>
        @include('home.homecss')
   </head>
   <body>
      <div class="header_section">
        @include('home.header')
        <!-- @include('home.banner') -->
      </div>
      @include('home.blogs')
      @include('home.footer')
      </body>
</html>
