
<!-- the main admin home -->

<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css ')
  </head>
  <body>
    @include('admin.header')
    <div class="d-flex align-items-stretch">

      <!-- Sidebar Navigation-->
    @include('admin.sidebar')
      <!-- Sidebar Navigation end-->

      @include('admin.body')
      <!-- itll show the 3 latest post and forms that are active and pending -->

        @include('admin.footer')
  </body>
</html>