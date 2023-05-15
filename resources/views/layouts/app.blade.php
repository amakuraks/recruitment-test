<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}{{ isset($title) ? ' | '.$title : '' }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="/css/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/css/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/css/adminlte.min.css">

    @stack('stylesheet')
</head>

<body class="sidebar-mini layout-fixed layout-navbar-fixed">

    @include('sweetalert::alert')

    <div class="wrapper">
        @include('layouts.navbar')
        @include('layouts.sidebar')

        <div class="content-wrapper px-md-5 text-sm">
            @include('layouts.bread')
            @yield('content')
        </div>
    </div>

    <script src="/js/jquery/jquery.min.js"></script>
    <script src="/js/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/js/adminlte.min.js"></script>
    @stack('js')
</body>
</html>
