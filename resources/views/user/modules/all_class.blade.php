{{-- resources/views/modules/all-classes.blade.php --}}
<x-app-layout>
    <div class="flex min-h-screen">

        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

        {{-- PERBAIKAN: Tambahkan 'flex flex-col' ke sidebar --}}
        <div id="sidebar" class="w-80 bg-[#021028] min-h-screen p-6 fixed top-0 left-0 transform -translate-x-full md:translate-x-0 md:static md:block transition-transform duration-300 ease-in-out z-50 flex flex-col">
            <div class="flex justify-end md:hidden mb-4">
                <button id="closeSidebar" class="text-gray-300 hover:text-white text-2xl font-bold p-2 focus:outline-none">
                    &times;
                </button>
            </div>
            <div class="space-y-2 flex flex-col flex-grow"> <!-- Tambahkan flex-col di sini -->
                <a href="{{ route('dashboard') }}" class="block w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors {{ Request::routeIs('dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    New & For You
                </a>
                <a href="{{ route('all.class') }}" class="block w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors {{ Request::routeIs('all.class') ? 'bg-gray-700 text-white' : '' }}">
                    All Classes
                </a>
                <a href="{{ route('news.index') }}" class="block w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors {{ Request::routeIs('research.class') ? 'bg-gray-700 text-white' : '' }}">
                    News Economic
                </a>
                <a href="{{ route('research.class') }}" class="block w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors {{ Request::routeIs('research.class') ? 'bg-gray-700 text-white' : '' }}">
                    Research
                </a>
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
                    @forelse($allModules as $module)
                        @php
                            $hasAccess = in_array($module->id, $userApprovedModuleIds);
                        @endphp
                        <div class="bg-gray-900 border border-gray-700 rounded-lg overflow-hidden hover:border-gray-600 transition-colors">
                            <a href="{{ route('module.detail', $module->id) }}" class="block">
                                <div class="relative">
                                    {{-- Menggunakan Storage::url() untuk gambar yang disimpan di storage/app/public --}}
                                    <img src="{{ $module->image ? Storage::url($module->image) : 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=300&h=160&fit=crop&crop=center' }}"
                                         alt="{{ $module->name ?? 'Gambar Modul' }}"
                                         class="w-full h-40 object-cover">
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-green-500 text-black px-2 py-1 rounded text-xs font-medium">
                                            {{ $module->module_type ? ucfirst($module->module_type) : 'Class' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-white mb-2">{{ $module->name ?? 'Nama Modul' }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $module->description ?? '' }}</p>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-400 col-span-full">Tidak ada kelas yang tersedia saat ini.</p>
                    @endforelse
                </div>
                {{-- Pagination di luar loop --}}
<div class="mt-6">
    {{ $allModules->links() }}
</div>
            </div>
        </div>
    </div>

{{-- Script untuk interaktivitas sidebar --}}
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const closeButton = document.getElementById('closeSidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const sidebarLinks = document.querySelectorAll('#sidebar a'); // Selektor untuk semua link di sidebar

    // Fungsi untuk membuka sidebar
    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');
    }

    // Fungsi untuk menutup sidebar
    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
    }

    // Event listener untuk tombol buka sidebar (☰ Menu)
    if (toggleButton) {
        toggleButton.addEventListener('click', openSidebar);
    }

    // Event listener untuk tombol tutup sidebar (X)
    if (closeButton) {
        closeButton.addEventListener('click', closeSidebar);
    }

    // Event listener untuk klik di overlay (menutup sidebar)
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }

    // Logika untuk menandai link aktif dan menutup sidebar setelah klik (di mobile)
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function () {
            // Hapus kelas aktif dari semua link
            sidebarLinks.forEach(item => {
                item.classList.remove('bg-gray-700', 'text-white');
                item.classList.add('text-gray-300', 'hover:text-white', 'hover:bg-gray-800');
            });

            // Tambahkan kelas aktif ke link yang diklik
            this.classList.add('bg-gray-700', 'text-white');
            this.classList.remove('text-gray-300', 'hover:text-white', 'hover:bg-gray-800');

            // Tutup sidebar di mobile setelah mengklik link
            if (window.innerWidth < 768) {
                closeSidebar();
            }
        });
    });

    // Responsif: pastikan sidebar tampil/tersembunyi sesuai ukuran layar
    function checkSidebarState() {
        if (window.innerWidth >= 768) { // Ukuran desktop (md breakpoint)
            sidebar.classList.remove('-translate-x-full'); // Pastikan sidebar selalu terlihat
            sidebar.classList.add('static', 'block'); // Lepaskan dari posisi fixed/transform
            sidebarOverlay.classList.add('hidden'); // Sembunyikan overlay
        } else { // Ukuran mobile
            sidebar.classList.add('-translate-x-full'); // Pastikan sidebar tersembunyi
            sidebar.classList.remove('static', 'block'); // Kembali ke posisi fixed/transform untuk mobile
            sidebarOverlay.classList.add('hidden'); // Pastikan overlay juga tersembunyi
        }
    }

    // Panggil saat halaman dimuat dan saat ukuran jendela berubah
    window.addEventListener('resize', checkSidebarState);
    checkSidebarState(); // Panggil saat awal untuk mengatur kondisi default
});
</script>
@endpush
</x-app-layout>