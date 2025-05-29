<x-app-layout>
    <div class="flex min-h-screen">
        {{-- Sidebar Overlay untuk Mobile --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

        {{-- Sidebar (Pastikan link 'News Economic' diarahkan ke route('news.index')) --}}
    {{-- Sidebar (Pastikan link 'News Economic' diarahkan ke route('news.index')) --}}
  {{-- Sidebar (Pastikan link 'News Economic' diarahkan ke route('news.index')) --}}
<div id="sidebar" class="w-80 bg-[#021028] min-h-screen p-6 fixed top-0 left-0 transform -translate-x-full md:translate-x-0 md:static md:block transition-transform duration-300 ease-in-out z-50 flex flex-col">
    <div class="flex justify-end md:hidden mb-4">
        <button id="closeSidebar" class="text-gray-300 hover:text-white text-2xl font-bold p-2 focus:outline-none">
            &times;
        </button>
    </div>
    {{-- PERBAIKAN: Tambahkan 'flex flex-col' di sini --}}
    <div class="space-y-2 flex flex-col flex-grow">
        <a href="{{ route('dashboard') }}" class="block w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors {{ Request::routeIs('dashboard') ? 'bg-gray-700 text-white' : '' }}">
            New & For You
        </a>
        <a href="{{ route('all.class') }}" class="block w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors {{ Request::routeIs('all.class') ? 'bg-gray-700 text-white' : '' }}">
            All Classes
        </a>
        {{-- Link untuk News Economic (diarahkan ke route news.index) --}}
        <a href="{{ route('news.index') }}" class="block w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors {{ Request::routeIs('news.index') ? 'bg-gray-700 text-white' : '' }}">
            News Economic
        </a>
        <a href="{{ route('research.class') }}" class="block w-full text-left px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors {{ Request::routeIs('research.class') ? 'bg-gray-700 text-white' : '' }}">
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

            <h1 class="text-gray-300 text-xl ml-8 mb-6 ">Berita Ekonomi Terbaru</h1>

            {{-- Mengubah grid menjadi satu kolom untuk list item --}}
            <div class="max-w-4xl mx-auto space-y-8"> {{-- Menggunakan max-w-4xl dan mx-auto untuk memusatkan konten --}}
                @forelse ($news as $item)
                    <div class=" rounded-lg shadow-md overflow-hidden border mt-[60px] border-gray-700 hover:border-gray-600 transition-colors flex flex-col md:flex-row">
                        <a href="{{ route('news.show', $item->slug) }}" class="flex flex-col md:flex-row w-full">
                            {{-- Bagian Gambar (Kiri) --}}
                            <div class="md:w-1/3 flex-shrink-0"> {{-- Ambil 1/3 lebar untuk gambar di desktop --}}
                                @if ($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-full h-48 md:h-full object-cover">
                                @else
                                    {{-- Placeholder jika tidak ada gambar --}}
                                    <img src="https://via.placeholder.com/400x280?text=No+Image" alt="No Image" class="w-full h-48 md:h-full object-cover bg-gray-800 text-gray-400 flex items-center justify-center">
                                @endif
                            </div>

                            {{-- Bagian Konten (Kanan) --}}
                            <div class="p-4 md:p-6 flex-grow"> {{-- Padding lebih besar di desktop --}}
                                <h3 class="text-xl font-semibold mb-2 text-white">{{ $item->title }}</h3>
                                <p class="text-sm text-gray-400 mb-3">
                                    Oleh: <span class="font-medium text-gray-300">{{ $item->author ?? 'Admin' }}</span> |
                                    <span class="font-medium text-gray-300">{{ $item->published_at ? $item->published_at->format('d M Y') : 'Belum Dipublikasi' }}</span>
                                </p>
                                {{-- Tampilkan sebagian kecil konten --}}
                                <p class="text-sm text-gray-500 mb-4 leading-relaxed">{{ Str::limit(strip_tags($item->content), 200) }}</p> {{-- Batas lebih panjang --}}
                                <span class="text-indigo-600 hover:text-indigo-900 font-semibold text-sm">
                                    Baca Selengkapnya
                                </span>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-gray-400 col-span-full text-center">Tidak ada berita yang tersedia saat ini.</p>
                @endforelse
            </div>

            <div class="mt-6 max-w-4xl mx-auto"> {{-- Sesuaikan lebar pagination agar sama dengan konten --}}
                {{ $news->links() }}
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