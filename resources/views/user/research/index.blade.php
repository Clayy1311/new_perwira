<x-app-layout>
    <div class="flex min-h-screen">
        {{-- Overlay --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

        {{-- Sidebar --}}
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

            <h1 class="text-gray-300 text-xl ml-8 mb-6">Daftar Research Saya</h1>

            {{-- Jika PDF sedang dibuka --}}
            @if (isset($selectedResearch) && $selectedResearch)
                <div class="flex flex-col h-[calc(100vh-120px)] bg-gray-900 rounded-lg shadow-lg overflow-hidden">
                    <div class="flex justify-between items-center p-3 bg-gray-800 border-b border-gray-700">
                        <h2 class="text-lg font-semibold text-white">{{ $selectedResearch->title }}</h2>
                        <a href="{{ route('research.class') }}" class="text-gray-400 hover:text-white text-xl font-bold p-2">&times; Tutup</a>
                    </div>

                    {{-- PDF Viewer --}}
                    <div class="pdf-viewer flex-grow w-full overflow-auto p-4 bg-gray-950 text-white">
                        <div id="pdfContainer" class="flex flex-col items-center justify-center min-h-full">
                            <canvas id="the-canvas" class="border border-gray-700 shadow-lg"></canvas>
                            <div class="mt-4 flex items-center space-x-4">
                                <button id="prev" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                    Halaman Sebelumnya
                                </button>
                                <span class="text-lg">Halaman: <span id="page_num"></span> / <span id="page_count"></span></span>
                                <button id="next" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                    Halaman Selanjutnya
                                </button>
                            </div>
                            <div class="text-red-500 mt-2" id="pdf-error-message" style="display:none;"></div>
                        </div>
                    </div>

                    {{-- PDF.js --}}
                    @push('scripts')
                    <script type="module">
                        import { getDocument, GlobalWorkerOptions } from 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.3.136/pdf.min.mjs';

                        GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.3.136/pdf.worker.min.mjs';

                        let pdfDoc = null,
                            pageNum = 1,
                            pageRendering = false,
                            pageNumPending = null,
                            scale = 1.5,
                            canvas = document.getElementById('the-canvas'),
                            ctx = canvas.getContext('2d');

                        const pdfUrl = '{{ Storage::url($selectedResearch->file_path) }}';

                        function renderPage(num) {
                            pageRendering = true;
                            pdfDoc.getPage(num).then(function (page) {
                                const viewport = page.getViewport({ scale });
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;

                                const renderContext = {
                                    canvasContext: ctx,
                                    viewport: viewport,
                                };
                                const renderTask = page.render(renderContext);
                                renderTask.promise.then(function () {
                                    pageRendering = false;
                                    if (pageNumPending !== null) {
                                        renderPage(pageNumPending);
                                        pageNumPending = null;
                                    }
                                });
                            });
                            document.getElementById('page_num').textContent = num;
                        }

                        function queueRenderPage(num) {
                            if (pageRendering) {
                                pageNumPending = num;
                            } else {
                                renderPage(num);
                            }
                        }

                        document.getElementById('prev').addEventListener('click', function () {
                            if (pageNum > 1) {
                                pageNum--;
                                queueRenderPage(pageNum);
                            }
                        });

                        document.getElementById('next').addEventListener('click', function () {
                            if (pageNum < pdfDoc.numPages) {
                                pageNum++;
                                queueRenderPage(pageNum);
                            }
                        });

                        getDocument(pdfUrl).promise.then(function (pdfDoc_) {
                            pdfDoc = pdfDoc_;
                            document.getElementById('page_count').textContent = pdfDoc.numPages;
                            renderPage(pageNum);
                        }).catch(function (error) {
                            console.error('Gagal memuat PDF:', error);
                            const errMsg = document.getElementById('pdf-error-message');
                            errMsg.style.display = 'block';
                            errMsg.textContent = 'Gagal memuat PDF: ' + error.message;
                        });
                    </script>
                    @endpush
                </div>
            @else
                {{-- Daftar Research --}}
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            @forelse ($researches as $research)
                                <div class="bg-gray-900 rounded-lg shadow-md overflow-hidden">
                                    <img src="{{ Storage::url($research->image) }}" alt="{{ $research->title }}" class="w-full h-48 object-cover cursor-pointer"
                                        onclick="window.location.href = '{{ route('research.class', ['view_pdf' => $research->id]) }}'">
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold mb-2 text-white">{{ $research->title }}</h3>
                                        <p class="text-sm text-gray-500 mb-2">{{ $research->created_at->format('d M Y') }}</p>
                                        <a href="{{ route('research.class', ['view_pdf' => $research->id]) }}"
                                            class="text-indigo-600 hover:text-indigo-900 font-semibold text-sm">
                                            Lihat PDF
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400 col-span-full">Tidak ada research yang tersedia saat ini.</p>
                            @endforelse
                        </div>

                        <div class="mt-6">
                            {{ $researches->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Sidebar Script --}}
    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleButton = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const closeButton = document.getElementById('closeSidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            toggleButton?.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
            });

            closeButton?.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            });

            sidebarOverlay?.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            });
        });
    </script>
    @endpush
</x-app-layout>
