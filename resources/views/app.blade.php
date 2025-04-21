<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Marsi App</title>
    @vite(['resources/js/app.js'])
</head>
<body class="m-0 p-0 h-screen">
<div id="app" data-page="{{ $page ?? 'home' }}" class="h-full"></div>
</body>
</html>
