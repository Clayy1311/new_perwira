<x-app-layout>
    {{-- PASTIKAN meta tag CSRF token ada di head LAYOUT Anda, misalnya app.blade.php --}}
    {{-- YANG SUDAH DIUPDATE DI ATAS --}}

    <div class="flex min-h-screen">

        {{-- Bagian Sidebar Anda (tetap sama) --}}


        {{-- Overlay untuk Sidebar di Mobile --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden md:hidden"></div>


        {{-- Main Content --}}
        <div class="flex-1 p-8 bg-black">
            <div class="md:hidden flex justify-end mb-4">
                <button id="toggleSidebar" class="bg-[#021028] text-white px-4 py-2 rounded">
                    ☰ Menu
                </button>
            </div>

            <h1 class="text-gray-300 text-3xl font-bold mb-6">{{ $module->name ?? 'Nama Modul' }}</h1>
            <p class="text-gray-400 mb-8">{{ $module->description ?? '' }}</p>

            {{-- PROGRESS BAR --}}
            <div class="mb-8">
                <h2 class="text-white text-lg mb-2">Progres Modul: {{ $module->progress_for_current_user ?? 0 }}%</h2>
                <div class="w-full bg-gray-700 rounded-full h-2.5">
                    <div class="bg-green-500 h-2.5 rounded-full"
                        style="width: {{ $module->progress_for_current_user ?? 0 }}%"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                {{-- Daftar Poin --}}
                <div class="md:col-span-1 bg-gray-900 border border-gray-700 rounded-lg p-4">
                    <h2 class="text-xl font-semibold mb-4 text-white">Daftar Poin</h2>
                    <ul class="space-y-2">
                        @forelse($module->points as $p)
                            @php
                                $isActivePoint = $point && $p->id === $point->id;
                                $isCompleted = in_array($p->id, $completedPointIds);
                            @endphp
                            <li>
                                <a href="{{ route('detail.points', ['module' => $module->id, 'point' => $p->id]) }}"
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors
                                           {{ $isActivePoint ? 'bg-purple-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}
                                           {{ $isCompleted ? 'line-through text-gray-500' : '' }}">
                                    {{-- SVG --}}
                                    <svg class="w-5 h-5 {{ $isCompleted ? 'text-green-500' : 'text-gray-500' }}"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        @if ($isCompleted)
                                            <path fill-rule="evenodd"
                                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.532-1.676-1.676a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                                clip-rule="evenodd" />
                                        @else
                                            <path
                                                d="M5 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H5.5a.5.5 0 0 1-.5-.5Zm0 3a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H5.5a.5.5 0 0 1-.5-.5Zm0 3a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H5.5a.5.5 0 0 1-.5-.5ZM3 10a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H3Zm0 1a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1H3Zm0 1a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H3.5a.5.5 0 0 1-.5-.5Z" />
                                        @endif
                                    </svg>
                                    <span>{{ $p->order }}. {{ $p->title ?? 'Judul Poin' }}</span>
                                </a>
                            </li>
                        @empty
                            <li>
                                <p class="text-gray-400">Tidak ada poin untuk modul ini.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>

                {{-- Konten Poin yang Aktif --}}
                <div class="md:col-span-3 bg-gray-900 border border-gray-700 rounded-lg p-6">
                    @if ($point)
                        <h2 class="text-2xl font-semibold mb-4 text-white">{{ $point->title ?? 'Judul Poin' }}</h2>

                        @php
                            $originalUrl = $point->content_url ?? '';
                            $videoId = null;
                            $isYouTubeVideo = false;
                            $isPdf = false;

                            if ($originalUrl) {
                                if (
                                    preg_match(
                                        '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i',
                                        $originalUrl,
                                        $matches,
                                    )
                                ) {
                                    $videoId = $matches[1];
                                    $isYouTubeVideo = true;
                                }
                            }

                            if (
                                \Illuminate\Support\Str::endsWith(\Illuminate\Support\Str::lower($originalUrl), '.pdf')
                            ) {
                                $isPdf = true;
                            }
                        @endphp

                        {{-- Tombol Tampilkan Konten --}}
                        @if ($isYouTubeVideo || $isPdf)
                            <button
                                onclick="document.getElementById('konten-media').classList.remove('hidden'); this.classList.add('hidden');"
                                class="mb-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                Mulai Belajar!!
                            </button>
                        @endif

                        {{-- Konten Multimedia --}}
                        <div id="konten-media" class="hidden mb-6">
                            @if ($isYouTubeVideo && $videoId)
                                <video style="width:100%;height:540px;" id="youtube_video_player"
                                    class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto"
                                    data-setup='{
                                  "techOrder": ["youtube"],
                                  "sources": [{ "type": "video/youtube", "src": "https://www.youtube.com/watch?v={{ $videoId }}&mode=opaque&amp;rel=0&amp;autohide=1&amp;showinfo=0&amp;wmode=transparent" }],
                                  "youtube": {
                                    "modestbranding": 1,
                                    "rel": 0,
                                    "controls": 1,
                                    "fs": 0,
                                    "playsinline": 1
                                  }
                                }'></video>
                            @elseif ($isPdf)
                                <div class="relative mb-4">
                                    <button onclick="openFullscreen('pdf-viewer')"
                                        class="absolute top-2 right-2 z-10 bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-sm" id="op-full">
                                        Fullscreen
                                    </button>

                                    <div id="pdf-viewer">
                                        <button onclick="exitFullscreen('pdf-viewer')"
                                            class="hidden absolute top-2 right-2 z-10 bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-sm" id="ex-full">
                                            Exit Fullscreen
                                        </button>
                                        <iframe
                                            src="{{ config('app.url') }}{{ $point->content_url }}#toolbar=0&navpanes=0&scrollbar=0"
                                            style="width:100%; height:600px;" width="100%" height="100%"
                                            frameborder="0">
                                        </iframe>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-400">Konten tidak dikenali atau tidak didukung (bukan video YouTube
                                    atau PDF).</p>
                            @endif
                        </div>

                        {{-- Konten Teks --}}
                        <div class="prose prose-invert text-gray-300 max-w-none mt-6">
                            {!! $point->content_text ?? '' !!}
                        </div>

                        {{-- Tombol Tandai Selesai --}}
                        @if (!in_array($point->id, $completedPointIds))
                            <button id="markCompleteBtn" data-module-id="{{ $module->id }}"
                                data-point-id="{{ $point->id }}"
                                class="mt-6 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                                Tandai Selesai
                            </button>
                        @endif
                    @else
                        <p class="text-gray-400">Pilih poin dari daftar di samping untuk memulai belajar.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <style>
        .ytp-share-button {
            display: none;
        }
    </style>

    {{-- Script Anda (dengan penambahan logging untuk debugging) --}}
    @push('scripts')
        <script>
            const openFullscreenButton = document.querySelector('#op-full');
            const exitFullscreenButton = document.querySelector('#ex-full');
            let fullscreenElement = null;

            function openFullscreen(id) {
                console.log("openfullscreen");
                const elem = document.getElementById(id);
                fullscreenElement = elem;
                fullscreenElement.addEventListener('fullscreenchange', onExitFullscreen);
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.webkitRequestFullscreen) {
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen();
                }
            }

            function exitFullscreen(id) {
                console.log("exit fullscreen");
                const elem = document.getElementById(id);
                if(fullscreenElement){
                    fullscreenElement.removeEventListener('fullscreenchange', onExitFullscreen);
                }
                // if(elem.exitFullscreen) {
                //     elem.exitFullscreen();
                // } else if (elem.webkitExitFullscreen) {
                //     /* Safari */
                //     elem.webkitExitFullscreen();
                // } else if (elem.msExitFullscreen) {
                //     /* IE11 */
                //     elem.msExitFullscreen();
                // }
            }

            function onExitFullscreen(ev){
                const isFullscreen = !exitFullscreenButton.classList.contains('hidden');
                exitFullscreenButton.classList.toggle('hidden');
                console.log(ev, isFullscreen);
            }

            // Inisialisasi Video.js player jika ada
            var player;
            if (document.getElementById('youtube_video_player')) {
                player = videojs('youtube_video_player');
            }

            document.addEventListener('DOMContentLoaded', function() {
                const toggleButton = document.getElementById('toggleSidebar');
                const sidebar = document.getElementById('sidebar');
                const closeButton = document.getElementById('closeSidebar');
                const sidebarOverlay = document.getElementById('sidebar-overlay');
                const markCompleteBtn = document.getElementById('markCompleteBtn');

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
                        if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
                    } else {
                        sidebar.classList.add('-translate-x-full');
                        sidebar.classList.remove('static', 'block');
                    }
                }

                checkSidebarState();
                window.addEventListener('resize', checkSidebarState);

                const currentPathname = window.location.pathname;
                document.querySelectorAll('.space-y-2 a').forEach(link => {
                    const linkPathname = new URL(link.href).pathname;

                    if (linkPathname === currentPathname || (linkPathname === '/' && currentPathname ===
                            '/dashboard')) {
                        link.classList.remove('text-gray-300', 'hover:text-white', 'hover:bg-gray-800');
                        link.classList.add('bg-gray-700', 'text-white');
                    } else {
                        link.classList.remove('bg-gray-700', 'text-white');
                        link.classList.add('text-gray-300', 'hover:text-white', 'hover:bg-gray-800');
                    }

                    link.addEventListener('click', function() {
                        if (window.innerWidth < 768) {
                            closeSidebar();
                        }
                    });
                });

                // LOGIKA UNTUK TOMBOL "Tandai Selesai"
                console.log('DOM Content Loaded. Checking for markCompleteBtn...');
                if (markCompleteBtn) {
                    console.log('Tombol Mark as Complete Ditemukan!');
                    markCompleteBtn.addEventListener('click', function() {
                        console.log('Tombol Mark as Complete Diklik!');

                        const moduleId = this.dataset.moduleId;
                        const pointId = this.dataset.pointId;

                        console.log(`Mengirim request untuk Module ID: ${moduleId}, Point ID: ${pointId}`);

                        // Pastikan URL sesuai dengan rute Laravel Anda
                        const url = `/modules/${moduleId}/points/${pointId}/complete`;

                        fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON
                                .stringify({}) // Anda mungkin perlu mengirim data tambahan di sini
                            })
                            .then(response => {
                                console.log('Response received. Status:', response.status);
                                if (!response.ok) {
                                    return response.json().then(errorData => {
                                        console.error('Error data from server:', errorData);
                                        throw new Error(errorData.message ||
                                            'Terjadi kesalahan pada server.');
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Success data from server:', data);
                                if (data.message) {
                                    alert(data.message);
                                    // Opsional: Perbarui tampilan tanpa memuat ulang halaman penuh
                                    // Misalnya, hilangkan tombol "Tandai Selesai" atau ubah tampilannya.
                                    location.reload(); // Untuk saat ini, muat ulang halaman.
                                }
                            })
                            .catch(error => {
                                console.error('Fetch error during Mark as Complete:', error);
                                alert('Terjadi kesalahan saat menandai poin: ' + error.message);
                            });
                    });
                } else {
                    console.warn(
                        'Tombol Mark as Complete TIDAK Ditemukan di DOM. Mungkin karena kondisi Blade atau ID salah.'
                        );
                }
            });
        </script>
    @endpush
</x-app-layout>
