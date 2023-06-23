<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Auth</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-primary">
<div id="layoutAuthentication">
    @yield('contentauth')

</div>

@vite(['resources/js/app.js'])
</body>
</html>
