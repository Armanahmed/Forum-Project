<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('include_main._head')
</head>
<body>
   <div id="app">

      @include('include_main._nav')

      <main class="py-4">
         @yield('content')
      </main>
      
   </div>

    @include('include_main._scripts')
    @yield('custom_scripts')
</body>
</html>
