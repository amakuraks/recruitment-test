<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }} @yield('subtitle')</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/css/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/css/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">

    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <div class="login-logo">
                    <a href="{{route('login')}}"><img src="/img/bati-full.png" width="200"></a>
                </div>
                @yield('box_content')
            </div>
        </div>
    </div>
</body>

<script src="/js/jquery/jquery.min.js"></script>
<script src="/js/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/adminlte.min.js"></script>

</html>
