<x-app-layout>
    <div class="flex min-h-screen">
        {{-- Sidebar Overlay untuk Mobile --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

        {{-- Sidebar (Pastikan link 'News Economic' diarahkan ke route('news.index')) --}}
        <div id="sidebar" class="w-80 bg-[#021028] min-h-screen p-6 fixed top-0 left-0 transform -translate-x-full md:translate-x-0 md:static md:block transition-transform duration-300 ease-in-out z-50 flex flex-col">
            <div class="flex justify-end md:hidden mb-4">
                <button id="closeSidebar" class="text-gray-300 hover:text-white text-2xl font-bold p-2 focus:outline-none">
                    &times;
                </button>
            </div>
            <div class="space-y-2 flex-grow">
                <a href="{{ route('dashboard') }}" class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors {{ Request::routeIs('dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    New & For You
                </a>
                <a href="{{ route('all.class') }}" class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors {{ Request::routeIs('all.class') ? 'bg-gray-700 text-white' : '' }}">
                    All Classes
                </a>
                {{-- Link untuk News Economic --}}
                <a href="{{ route('news.index') }}" class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors {{ Request::routeIs('news.index') ? 'bg-gray-700 text-white' : '' }}">
                    News Economic
                </a>
                <a href="{{ route('research.class') }}" class="w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors {{ Request::routeIs('research.class') ? 'bg-gray-700 text-white' : '' }}">
                 Research
                </a>
            </div>
        </div>

        {{-- Konten Utama --}}
        <div class="flex-1 p-8 bg-black">
            {{-- Tombol menu mobile --}}
            <div class="md:hidden flex justify-end mb-4">
                <button id="toggleSidebar" class="bg-[#021028] text-white px-4 py-2 rounded">
                    ☰ Menu
                </button>
            </div>

            <div class="max-w-4xl mx-auto bg-gray-900 rounded-lg shadow-lg p-6 border border-gray-700">
                {{-- Tombol Kembali --}}
                <div class="mb-6">
                    <a href="{{ route('news.index') }}" class="text-indigo-500 hover:text-indigo-400 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Daftar Berita
                    </a>
                </div>

                {{-- Gambar Berita --}}
                @if ($news->image)
                    <div class="mb-6">
                        <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}" class="w-full h-80 object-cover rounded-lg shadow-md">
                    </div>
                @else
                    <div class="mb-6 flex justify-center items-center h-80 bg-gray-800 rounded-lg shadow-md text-gray-400 text-xl">
                        Tidak ada gambar untuk berita ini
                    </div>
                @endif

                {{-- Judul Berita --}}
                <h1 class="text-3xl font-bold text-white mb-4">{{ $news->title }}</h1>

                {{-- Informasi Berita --}}
                <p class="text-sm text-gray-400 mb-6">
                    Oleh: <span class="font-semibold text-gray-300">{{ $news->author ?? 'Admin' }}</span> |
                    Publikasi: <span class="font-semibold text-gray-300">{{ $news->published_at ? $news->published_at->format('d F Y') : 'Belum Dipublikasi' }}</span>
                </p>

                {{-- Konten Berita --}}
                <div class="prose prose-invert text-gray-300 max-w-none">
                    {{-- Gunakan {!! !!} untuk merender HTML dari konten jika disimpan sebagai HTML --}}
                    {{-- Jika content_text hanya teks biasa, Anda mungkin ingin menggunakan nl2br(e($news->content)) --}}
                    {!! $news->content !!}
                </div>

            </div>
        </div>
    </div>

    {{-- Script Sidebar (sama seperti yang sudah ada) --}}
    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleButton = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const closeButton = document.getElementById('closeSidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const sidebarLinks = document.querySelectorAll('#sidebar a');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            }

            toggleButton?.addEventListener('click', openSidebar);
            closeButton?.addEventListener('click', closeSidebar);
            sidebarOverlay?.addEventListener('click', closeSidebar);

            sidebarLinks.forEach(link => {
                link.addEventListener('click', function () {
                    sidebarLinks.forEach(item => {
                        item.classList.remove('bg-gray-700', 'text-white');
                        item.classList.add('text-gray-300', 'hover:text-white', 'hover:bg-gray-800');
                    });
                    this.classList.add('bg-gray-700', 'text-white');
                    this.classList.remove('text-gray-300', 'hover:text-white', 'hover:bg-gray-800');

                    if (window.innerWidth < 768) {
                        closeSidebar();
                    }
                });

                const currentPath = window.location.pathname;
                const linkPath = new URL(link.href).pathname;

                if (linkPath === currentPath || (linkPath === '/dashboard' && currentPath === '/')) {
                    link.classList.add('bg-gray-700', 'text-white');
                    link.classList.remove('text-gray-300', 'hover:text-white', 'hover:bg-gray-800');
                }
            });

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

            window.addEventListener('resize', checkSidebarState);
            checkSidebarState();
        });
    </script>
    @endpush
</x-app-layout>