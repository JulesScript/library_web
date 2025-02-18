<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<head>


    @yield('head')
</head>

<body>

    <!-- ======= Header ======= -->
    @include('partials.header')

    <!-- ======= Sidebar ======= -->
    @include('partials.sidebar')

    <main id="main" class="main">
        @yield('content')
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('partials.footer')



    @yield('scripts')

</body>

</html>