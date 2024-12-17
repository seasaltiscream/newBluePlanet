

<!-- about us, following the usual layout -->
 <!-- if u wanna edit the about us section itself, its at about.blade.php -->

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
      @include('home.about')
      @include('home.footer')
      </body>
</html>