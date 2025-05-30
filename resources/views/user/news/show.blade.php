<x-app-layout>
    <div class="flex min-h-screen bg-black text-gray-300"> {{-- Pastikan background dan teks default gelap --}}

        {{-- Sidebar (Jika Anda ingin sidebar muncul di sini, uncomment bagian ini) --}}
        {{-- Jika sidebar Anda di-include di layout.navigation, Anda bisa hapus bagian ini --}}
        {{-- PERBAIKAN: Tambahkan 'flex flex-col' ke sidebar --}}
    
        {{-- Sidebar Overlay untuk Mobile --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>
        {{-- End Sidebar --}}


        {{-- Konten Utama --}}
  
            <div class="max-w-4xl mx-auto bg-gray-900 rounded-xl shadow-2xl p-8 border border-gray-700"> {{-- Peningkatan shadow dan rounded --}}
                {{-- Tombol Kembali --}}
                <div class="mb-8"> {{-- Margin lebih besar --}}
                    <a href="{{ route('news.index') }}" class="text-indigo-400 hover:text-indigo-300 flex items-center text-lg font-medium transition-colors duration-200"> {{-- Warna dan ukuran teks tombol kembali --}}
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Daftar Berita
                    </a>
                </div>

                {{-- Gambar Berita --}}
                @if ($news->image)
                    <div class="mb-8"> {{-- Margin lebih besar --}}
                        <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}" class="w-full h-96 object-cover rounded-xl shadow-xl border border-gray-800"> {{-- Ukuran lebih besar, shadow lebih kuat, border tipis --}}
                    </div>
                @else
                    <div class="mb-8 flex justify-center items-center h-96 bg-gray-800 rounded-xl shadow-xl text-gray-500 text-2xl border border-gray-700"> {{-- Ukuran, warna, border, shadow --}}
                        Tidak ada gambar untuk berita ini
                    </div>
                @endif

                {{-- Judul Berita --}}
                <h1 class="text-4xl font-extrabold text-white mb-4 leading-tight"> {{-- Ukuran font lebih besar, bold, leading --}}
                    {{ $news->title }}
                </h1>

                {{-- Informasi Berita --}}
                <p class="text-base text-gray-500 mb-8 border-b border-gray-700 pb-6"> {{-- Warna lebih lembut, border bawah --}}
                    Oleh: <span class="font-semibold text-gray-400">{{ $news->author ?? 'Admin' }}</span> |
                    Publikasi: <span class="font-semibold text-gray-400">{{ $news->published_at ? $news->published_at->format('d F Y') : 'Belum Dipublikasi' }}</span>
                </p>

                {{-- Konten Berita --}}
                <div class="prose prose-lg prose-invert text-gray-300 max-w-none leading-relaxed"> {{-- Prose lebih besar, line height --}}
                    {!! $news->content !!}
                </div>

            </div>
        </div>
    </div>

    {{-- Script Sidebar (sama seperti yang sudah ada, ini perlu di-uncomment agar sidebar berfungsi) --}}
    {{-- @push('scripts')
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

                // Cek apakah elemen ada sebelum menambahkan event listener
                if (toggleButton) {
                    toggleButton.addEventListener('click', openSidebar);
                }
                if (closeButton) {
                    closeButton.addEventListener('click', closeSidebar);
                }
                if (sidebarOverlay) {
                    sidebarOverlay.addEventListener('click', closeSidebar);
                }

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

                    // Penandaan link aktif
                    const currentPath = window.location.pathname;
                    const linkPath = new URL(link.href).pathname;

                    // Mengatasi kasus dashboard yang mungkin '/' atau '/dashboard'
                    const isDashboardLink = linkPath === '{{ route('dashboard', [], false) }}' || linkPath === '/';
                    const isCurrentDashboard = currentPath === '{{ route('dashboard', [], false) }}' || currentPath === '/';

                    if (linkPath === currentPath || (isDashboardLink && isCurrentDashboard && linkPath === currentPath)) {
                        link.classList.add('bg-gray-700', 'text-white');
                        link.classList.remove('text-gray-300', 'hover:text-white', 'hover:bg-gray-800');
                    } else if (linkPath === '{{ route('news.index', [], false) }}' && currentPath.startsWith('{{ route('news.index', [], false) }}')) {
                        // Menangani kasus detail berita agar link 'News Economic' tetap aktif
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
                checkSidebarState(); // Jalankan saat awal untuk mengatur state
            });
        </script>
    @endpush --}}
</x-app-layout>