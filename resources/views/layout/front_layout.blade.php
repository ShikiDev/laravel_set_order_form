<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Orders Page</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <!-- Scripts -->
    <script type="application/javascript" src="{{asset('js/app.js')}}" defer></script>
</head>
<body>
<header class="border-bottom box-shadow">
    <div class="container d-flex flex-column flex-md-row justify-content-between">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Order Foods</a>
        </nav>
    </div>
</header>
<main class="container">
    <div class="main-block mt-3 border box-shadow">
        <div class="row">
            <div class="col" id='app'>
                @yield('content')
            </div>
        </div>
    </div>
</main>
</body>
</html>
