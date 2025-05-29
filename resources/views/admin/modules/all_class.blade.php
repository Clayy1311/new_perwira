{{-- resources/views/modules/all-classes.blade.php --}}

<div class="flex min-h-screen">

    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

    <div id="sidebar" class="w-80 bg-[#021028] min-h-screen p-6 fixed top-0 left-0 transform -translate-x-full md:translate-x-0 md:static md:block transition-transform duration-300 ease-in-out z-50">
        <div class="flex justify-end md:hidden mb-4">
            <button id="closeSidebar" class="text-gray-300 hover:text-white text-2xl font-bold p-2 focus:outline-none">
                &times;
            </button>
        </div>

        <div class="space-y-2">
            <a href="{{ route('dashboard') }}" class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                New & For You
            </a>
            <a href="{{ route('all.classes') }}" class="w-full text-left px-4 py-3 bg-gray-700 text-white rounded-lg transition-colors">
                All Classes
            </a>
            <button class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                Crypto Trading
            </button>
            <button class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                Crypto Investing
            </button>
            <button class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                Blockchain Technology
            </button>
        </div>
    </div>

    <div class="flex-1 p-8 bg-black">
        <div class="md:hidden flex justify-end mb-4">
            <button id="toggleSidebar" class="bg-[#021028] text-white px-4 py-2 rounded">
                ☰ Menu
            </button>
        </div>

        <h1 class="text-gray-300 text-xl mb-6">All Classes</h1>

        <div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($allModules as $module) {{-- Iterasi semua $allModules, tanpa .take(3) --}}
                    @php
                        $hasAccess = in_array($module->id, $userApprovedModuleIds);
                    @endphp
                    <div class="bg-gray-900 border border-gray-700 rounded-lg overflow-hidden hover:border-gray-600 transition-colors cursor-pointer">
                        <a href="{{ $hasAccess ? route('detail.points', $module->id) : '#' }}">
                            <div class="relative">
                                <img src="{{ $module->image ? asset('storage/' . $module->image) : 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=300&h=160&fit=crop&crop=center' }}"
                                     alt="{{ $module->name ?? 'Gambar Modul' }}"
                                     class="w-full h-40 object-cover">
                                <div class="absolute top-3 left-3">
                                    <span class="bg-green-500 text-black px-2 py-1 rounded text-xs font-medium">
                                        {{ $module->module_type ? ucfirst($module->module_type) : 'Class' }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold mb-2">{{ $module->name ?? 'Nama Modul' }}</h3>
                                <p class="text-gray-400 text-sm">{{ $module->description ?? '' }}</p>
                            </div>
                        </a>
                        {{-- Tombol "Beli Modul" atau "Lanjutkan Belajar" bisa Anda tambahkan kembali di sini jika ini halaman penuhnya --}}
                        <div class="p-4 pt-0">
                            @if(!$hasAccess)
                                <a href="{{ route('payment.initiate', $module->id) }}" class="bg-green-500 hover:bg-green-600 text-black px-4 py-2 rounded text-sm font-medium transition-colors w-full text-center block">
                                    Beli Modul
                                </a>
                            @else
                                <a href="{{ route('detail.points', $module->id) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded text-sm font-medium transition-colors w-full text-center block">
                                    Lanjutkan Belajar
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4">
                        {{ $allModules->links() }} {{-- menampilkan pagination --}}
                    </div>
                    
                @empty
                    <p class="text-gray-400 col-span-full">Tidak ada kelas yang tersedia saat ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Script untuk interaktivitas sidebar (akan di-push ke @stack('scripts') di app.blade.php) --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const closeButton = document.getElementById('closeSidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            }

            if (toggleButton) {
                toggleButton.addEventListener('click', openSidebar);
            }

            if (closeButton) {
                closeButton.addEventListener('click', closeSidebar);
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
            }

            function checkSidebarState() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('static', 'block');
                    sidebarOverlay.classList.add('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('static', 'block');
                    sidebarOverlay.classList.add('hidden');
                }
            }

            checkSidebarState();
            window.addEventListener('resize', checkSidebarState);

            // Logika untuk menandai tombol aktif di sidebar berdasarkan URL
            // Ini akan perlu sedikit adaptasi karena sekarang ada link <a>
            const currentPath = window.location.pathname;
            document.querySelectorAll('.space-y-2 a').forEach(link => { // Ubah dari button menjadi a
                if (link.href === window.location.href) { // Cek apakah URL link sama dengan URL saat ini
                    link.classList.remove('text-gray-300', 'hover:text-white', 'hover:bg-gray-800');
                    link.classList.add('bg-gray-700', 'text-white');
                } else {
                    link.classList.remove('bg-gray-700', 'text-white');
                    link.classList.add('text-gray-300', 'hover:text-white', 'hover:bg-gray-800');
                }

                // Otomatis tutup sidebar di mobile setelah mengklik tombol navigasi
                link.addEventListener('click', function() { // Tambahkan event listener ke a
                    if (window.innerWidth < 768) {
                        closeSidebar();
                    }
                });
            });
        });
    </script>
@endpush