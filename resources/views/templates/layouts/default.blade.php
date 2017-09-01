<!DOCTYPE html>
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Helix - @yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta property="og:title" content="Helix - @yield('title')" />
    <meta property="og:type" content="website" />
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta property="og:image:type" content="image/png">
    <meta property="og:url" content="{{Request::url()}}" />
    <meta property="og:image" content="{{asset('images/helix.png')}}" />
    <meta property="og:description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="description" content="@yield('description')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon">
    <link rel="apple-touch-icon-precomposed" href="/images/apple-touch-icon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    @yield('head')
</head>
<body>
    <div id="fb-root"></div>
    <header>@include('templates.layouts.header')</header>
    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
    <footer>@include('templates.layouts.footer')</footer>
    @yield('script')

</body>
</html>