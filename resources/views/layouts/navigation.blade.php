<nav class="bg-black text-white px-6 py-4 flex items-center justify-between">
    <!-- Kiri: Logo + Find a course -->
    <div class="flex items-center space-x-3">
        <div class="bg-purple-600 p-2 rounded-lg">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2L2 10l8 8 8-8-8-8z" />
            </svg>
        </div>
        <span class="text-lg font-semibold">Find a course</span>
    </div>

    <!-- Tengah: Menu -->
    <div class="hidden md:flex space-x-6 text-sm">
        <a href="#" class="text-cyan-400 font-semibold">Academy</a>
        <a href="#" class="hover:text-gray-300">Research</a>
        <a href="#" class="hover:text-gray-300">Affiliate</a>
    </div>

    <!-- Kanan: User Info + Dropdown -->
    <div class="relative">
        <button onclick="toggleDropdown()" class="flex items-center space-x-2 text-sm focus:outline-none">
            <span>{{ Auth::user()->name }}</span>
            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                <path d="M5.25 7.5L10 12.25L14.75 7.5H5.25Z" />
            </svg>
        </button>

        <!-- Dropdown -->
        <div id="userDropdown" class="absolute right-0 mt-2 w-48 bg-white text-black rounded-md shadow-lg hidden z-50">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Edit Profile</a>
            <a href="{{ route('password.request') }}" class="block px-4 py-2 hover:bg-gray-100">Ganti Password</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
            </form>
        </div>
    </div>
</nav>

<!-- Script Toggle Dropdown -->
<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Optional: klik di luar dropdown untuk nutup
    window.addEventListener('click', function(e) {
        const dropdown = document.getElementById('userDropdown');
        const button = document.querySelector('button[onclick="toggleDropdown()"]');
        if (!button.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
