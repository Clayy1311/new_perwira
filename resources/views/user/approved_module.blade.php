{{-- resources/views/user/approved_module.blade.php --}}

{{--
    PENTING: JANGAN SERTAKAN TAG HTML LENGKAP (<!DOCTYPE html>, <html>, <head>, <body>) DI SINI.
    File ini akan di-include ke dalam layout utama (app.blade.php) Anda.
    Hapus juga <script src="https://cdn.tailwindcss.com"></script> karena Tailwind sudah dikelola oleh Vite di proyek Laravel Breeze Anda.
--}}

<div class="flex min-h-screen"> {{-- Tambahkan min-h-screen untuk memastikan flexbox bekerja dengan baik --}}

    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

    {{-- Perhatikan kelas:
        - fixed top-0 left-0: untuk posisi tetap di kiri atas
        - transform -translate-x-full: menyembunyikan sidebar di luar layar secara default di mobile
        - md:translate-x-0 md:static md:block: membuat sidebar muncul dan menjadi statis (bagian dari layout) di desktop
        - transition-transform duration-300 ease-in-out: animasi saat membuka/menutup
        - z-50: memastikan sidebar di atas konten lain
    --}}
    <div id="sidebar" class="w-80 bg-[#021028] min-h-screen p-6 fixed top-0 left-0 transform -translate-x-full md:translate-x-0 md:static md:block transition-transform duration-300 ease-in-out z-50">
        {{-- Tombol ini akan terlihat di samping area "New & For You" --}}
        <div class="flex justify-end md:hidden mb-4">
            <button id="closeSidebar" class="text-gray-300 hover:text-white text-2xl font-bold p-2 focus:outline-none">
                &times; {{-- Karakter 'X' besar --}}
            </button>
        </div>

        <div class="space-y-2">
            <button class="w-full text-left px-4 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors">
                New & For You
            </button>
            <button class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                <a href="{{ route('all.class') }}" class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                    All Classes
                </a> 
            </button>
            <button class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                <a href="{{ route('news.index') }}" class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                 News
                </a> 
            </button>
            <button class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                <a href="{{ route('research.class') }}" class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                 Research
                </a> 
            </button>
          
           
        </div>
    </div>

    <div class="flex-1 p-8 bg-black">
        <div class="md:hidden flex justify-end mb-4">
            <button id="toggleSidebar" class="bg-[#021028] text-white px-4 py-2 rounded">
                ☰ Menu
            </button>
        </div>

        <div class="mb-8">
            <h1 class="text-gray-300 text-xl mb-6">New & For You</h1>

            <div class="flex items-center justify-between mb-12 flex-col md:flex-row gap-6">
                <div>
                    <h2 class="text-5xl md:text-6xl font-bold mb-4 text-white leading-tight">
                        THE ART OF CRYPTO <br>
                        TRADING
                    </h2>
                </div>

                @if($approvedModules->isNotEmpty())
                    @php
                        $featuredModule = $approvedModules->first();
                    @endphp
                    
                    <div class="w-full md:w-96 overflow-hidden p-4 pl-[120px] pb-[70px]">
                        <div class="flex items-center space-x-4">
                            <img
                                src="{{ asset('assets/images/icon-50%.svg') }}"
                                alt="Perwira Crypto"
                                class="w-[81px] h-[104px]"
                            />
                    
                            <h1 class="text-white text-xl font-bold">   </h1>
                        </div>
                    </div>
                    
                @else
                    <p class="text-gray-400">Tidak ada modul unggulan yang tersedia.</p>
                @endif
            </div>
        </div>

        <div>
            <h2 class="text-2xl text-white font-semibold mb-6">Recomended For Started</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                {{-- Menggunakan approvedModules dan membatasi hanya 3 --}}
                @forelse($approvedModules->take(8) as $module)
                    <div class="bg-gray-900 border border-gray-700 rounded-lg overflow-hidden hover:border-gray-600 transition-colors cursor-pointer">
                        <a href="{{ route('module.detail', $module->id) }}">
                            <div class="relative">
                                {{-- Menggunakan asset() seperti kode awal Anda untuk gambar --}}
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
                                <h3 class="font-semibold text-white mb-2">{{ $module->name ?? '' }}</h3>
                                <p class="text-white text-sm">{{ $module->description ?? '' }}</p> {{-- Menampilkan deskripsi --}}
                                {{-- Menghilangkan "Lessons", "Poin Video", Progress, dan Price --}}
                            </div>
                        </a>
                        {{-- Menghilangkan tombol "Beli Modul" atau "Lanjutkan Belajar" --}}
                    </div>
                @empty
                    <p class="text-white col-span-full">Tidak ada kelas yang tersedia saat ini.</p>
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

            // Menangani status sidebar saat halaman dimuat dan ukuran jendela berubah
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

            checkSidebarState(); // Jalankan saat halaman dimuat
            window.addEventListener('resize', checkSidebarState); // Jalankan saat ukuran jendela berubah

            // Script yang sudah ada untuk status aktif tombol sidebar
            document.querySelectorAll('.space-y-2 button').forEach(button => {
                button.addEventListener('click', function () {
                    // Logika untuk menandai tombol aktif
                    document.querySelectorAll('.space-y-2 button').forEach(btn => {
                        btn.classList.remove('bg-gray-700');
                        btn.classList.add('text-gray-300', 'hover:text-white', 'hover:bg-gray-800');
                    });
                    this.classList.add('bg-gray-700');
                    this.classList.remove('text-gray-300', 'hover:text-white', 'hover:bg-gray-800');

                    // Otomatis tutup sidebar di mobile setelah mengklik tombol navigasi
                    if (window.innerWidth < 768) {
                        closeSidebar();
                    }
                });
            });
        });
    </script>
@endpush