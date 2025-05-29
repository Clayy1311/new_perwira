<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'crypto-purple': '#8b5cf6',
                        'crypto-cyan': '#06b6d4'
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-black text-white">

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-80 bg-[#021028] min-h-screen p-6">
            <div class="space-y-2">
                <button class="w-full text-left px-4 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors">
                    New & For You
                </button>
                <button class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                    All Classes
                </button>
                <button class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                    Crypto Trading
                </button>
                <button class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                    Crypto Investing
                </button>
                <button class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                    Blockchain Technology
                </button>
                <button class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                    Liveclass
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-gray-300 text-xl mb-6">New & For You</h1>

                <!-- Hero Section -->
                <div class="flex items-center justify-between mb-12 flex-col md:flex-row gap-6">
                    <div>
                        <h2 class="text-5xl md:text-6xl font-bold mb-4 leading-tight">
                            THE ART OF CRYPTO<br>
                            TRADING
                        </h2>
                    </div>

                    <!-- Featured Course Card -->
                    <div class="w-full md:w-96 bg-gray-900 border border-gray-700 rounded-lg overflow-hidden">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=400&h=200&fit=crop&crop=center" 
                                 alt="Bitcoin Trading Interface" 
                                 class="w-full h-48 object-cover">
                            <div class="absolute top-4 left-4">
                                <span class="bg-green-500 text-black px-2 py-1 rounded text-xs font-medium">
                                    Live Class
                                </span>
                            </div>
                            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-xl font-semibold mb-2">The Art of<br>Crypto Trading</h3>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400 text-sm">7 Lessons</span>
                                <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded text-sm font-medium transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                    Start
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- All Classes Section -->
            <div>
                <h2 class="text-2xl font-semibold mb-6">All Classes</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Course Card 1 -->
                    <div class="bg-gray-900 border border-gray-700 rounded-lg overflow-hidden hover:border-gray-600 transition-colors cursor-pointer">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=300&h=160&fit=crop&crop=center" 
                                 alt="Crypto Trading Course" 
                                 class="w-full h-40 object-cover">
                            <div class="absolute top-3 left-3">
                                <span class="bg-green-500 text-black px-2 py-1 rounded text-xs font-medium">
                                    Live Class
                                </span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold mb-2">The Art of<br>Crypto Trading</h3>
                        </div>
                    </div>

                    <!-- Course Card 2 -->
                    <div class="bg-gray-900 border border-gray-700 rounded-lg overflow-hidden hover:border-gray-600 transition-colors cursor-pointer">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1559526324-4b87b5e36e44?w=300&h=160&fit=crop&crop=center" 
                                 alt="Welcome to Akademi Crypto" 
                                 class="w-full h-40 object-cover">
                            <div class="absolute top-3 left-3">
                                <span class="bg-green-500 text-black px-2 py-1 rounded text-xs font-medium">
                                    Live Class
                                </span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold mb-2">Welcome to<br>Akademi Crypto</h3>
                        </div>
                    </div>

                    <!-- Course Card 3 -->
                    <div class="bg-gray-900 border border-gray-700 rounded-lg overflow-hidden hover:border-gray-600 transition-colors cursor-pointer">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1642790106117-e829e14a795f?w=300&h=160&fit=crop&crop=center" 
                                 alt="Crypto Portfolio Management" 
                                 class="w-full h-40 object-cover">
                            <div class="absolute top-3 left-3">
                                <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium">
                                    Crypto Investing
                                </span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold mb-2">Crypto Portfolio<br>Management</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add some basic interactivity
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', function () {
                if (this.parentElement.classList.contains('space-y-2')) {
                    document.querySelectorAll('.space-y-2 button').forEach(btn => {
                        btn.classList.remove('bg-gray-700');
                        btn.classList.add('text-gray-300', 'hover:text-white', 'hover:bg-gray-800');
                    });
                    this.classList.add('bg-gray-700');
                    this.classList.remove('text-gray-300', 'hover:text-white', 'hover:bg-gray-800');
                }
            });
        });
    </script>
</body>
</html>
