@props(['title' => null])
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title . ' — БаталБанк' : 'БаталБанк' }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/bank/logo-mark.svg') }}">
    @vite('resources/css/app.css')
</head>
<body class="bank">
    <a class="skip-link" href="#content">К содержимому</a>
    <x-bank-header />
    <main id="content">
        {{ $slot }}
    </main>
    <x-bank-footer />
</body>
</html>
