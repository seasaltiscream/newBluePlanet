
<!-- the main home -->

<!DOCTYPE html>
<html lang="en">
   <head>
        @include('home.homecss')
   </head>
   <body>
      <div class="header_section">
        @include('home.header')
        @include('home.banner')
      </div>
      @include('home.blogs')
      @include('home.forms')
      @include('home.about')
      @include('home.footer')
      </body>
</html>