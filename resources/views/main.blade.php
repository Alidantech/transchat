<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Your Default Title')</title>
        <link rel="shortcut icon" href="assets/favicon.svg" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="stylesheet" type="text/css" href="css/app.css">
        <link rel="stylesheet" type="text/css" href="css/welcome.css">
        <link rel="stylesheet" type="text/css" href="css/chat.css">
        <link rel="stylesheet" type="text/css" href="css/forms.css">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    </head>
    <body class="antialiased">
        <main>@yield('content')</main>
    </body>
</html>