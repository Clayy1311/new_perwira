<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

   <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-[#021028] dark:bg-black">
        @include('layouts.navigation')

        @if(isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main class="w-full">
            {{ $slot }}
        </main>

        @if(isset($footer))
            <footer class="bg-white dark:bg-gray-800 mt-8">
                {{ $footer }}
            </footer>
        @endif
    </div>

    {{-- PENTING: Pindahkan Video.js scripts ke SINI, SEBELUM @stack('scripts') --}}
    <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
    <script src="https://unpkg.com/videojs-youtube/dist/Youtube.min.js"></script>
    {{-- Optional: jika Anda juga menggunakan videojs-http-streaming, masukkan di sini juga --}}
    {{-- <script src="https://unpkg.com/@videojs/http-streaming@3.7.0/dist/videojs-http-streaming.min.js"></script> --}}

    @stack('scripts')
    
</body>
</html>