<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamatif | {{ date('Y') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/Logo.png') }}">

    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="bg-gray-100">
    <div id="app"></div>
</body>
</html>
