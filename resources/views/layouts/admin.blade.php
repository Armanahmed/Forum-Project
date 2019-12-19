<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include('include_admin._head') 
</head>

<body>
    <div id="app">
        <div id="wrapper">
            @include('include_admin._nav_top')

            @include('include_admin._nav_side')

            @yield('admincontent')
          
    		
        </div>
    </div>
    <!-- /. WRAPPER  -->

     @include('include_admin._scripts')

     @yield('custom_scripts')

</body>

</html>