<!DOCTYPE html>
<html>
<head>
  <title>@yield('title', 'Perwira Crypto')</title>
  <link rel="stylesheet" href="/css/app.css">
</head>
<body>

  @include('partials.navbar') <!-- Navbar -->
  
  <div class="container mx-auto p-6">
    @yield('content') <!-- Ini yang akan diisi oleh @section('content') -->
  </div>

  @yield('scripts') <!-- Tempat script tambahan -->
</body>
</html>
