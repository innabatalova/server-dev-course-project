@props(['title' => 'Мой блог', 'heading' => null])
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
</head>
<body>
    <x-header :heading="$heading ?? $title" />
    <main class="container">
        {{ $slot }}
    </main>
    <x-footer />
</body>
</html>