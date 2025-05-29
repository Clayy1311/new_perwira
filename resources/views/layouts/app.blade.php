<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-[#021028] dark:bg-black">
        @include('layouts.navigation')

        <!-- Dynamic Header Slot -->
        @if(isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Main Content Slot -->
        <main class="w-full">
            {{ $slot }}
        </main>

        <!-- Footer Slot -->
        @if(isset($footer))
            <footer class="bg-white dark:bg-gray-800 mt-8">
                {{ $footer }}
            </footer>
        @endif
    </div>

    <!-- Optional Scripts Slot -->
    @stack('scripts')
    
    <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
<script src="https://unpkg.com/videojs-youtube/dist/Youtube.min.js"></script>
</body>
</html>