<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h2 class="text-2xl font-bold mb-6">📌 Detail Modul</h2>

        @if($module)
            <div class="mb-4 border rounded-lg overflow-hidden">
                <button onclick="toggleContent('modulDetail')" class="w-full text-left px-4 py-3 bg-blue-700 text-white font-semibold hover:bg-blue-800 transition">
                    {{ $module->name ?? $module->judul ?? 'Nama Modul Tidak Tersedia' }}
                </button>
                <div id="modulDetail" class="p-4 bg-white"> {{-- Ini adalah div untuk detail modul keseluruhan --}}
                    <p class="mb-2 text-gray-800">📄 Deskripsi: {{ $module->description ?? $module->deskripsi ?? 'Deskripsi tidak tersedia.' }}</p>
<button><a href="{{ route('dashboard') }}">kembali</a></button>
                    @if($points->isNotEmpty())
                        <h3 class="text-lg font-semibold mt-4 mb-2">Daftar Poin Pembelajaran:</h3>
                        @foreach($points as $point)
                            {{-- START: Struktur baru untuk setiap poin sebagai dropdown --}}
                            <div class="mb-2 border rounded-lg overflow-hidden">
                                <button onclick="toggleContent('pointContent{{ $point->id }}')" class="w-full text-left px-4 py-3 bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300 transition">
                                    🎯 Point: {{ $point->title ?? $point->judul ?? 'Judul Poin Tidak Tersedia' }}
                                </button>
                                <div id="pointContent{{ $point->id }}" class="hidden p-4 bg-white border-t"> {{-- Konten poin disembunyikan secara default --}}

                                    {{-- Pengecekan dan Embed Video YouTube --}}
                                    @if($point->content_url)
                                        @php
                                            $originalUrl = $point->content_url;
                                            $embedUrl = '';
                                            $isYouTubeVideo = false;

                                            if (Str::contains($originalUrl, ['youtube.com/watch?v=', 'youtu.be/', 'youtube.com/embed/'])) { // Perbarui deteksi YouTube
                                                $isYouTubeVideo = true;
                                                if (Str::contains($originalUrl, 'watch?v=')) {
                                                    $videoId = Str::afterLast($originalUrl, 'watch?v=');
                                                    if (Str::contains($videoId, '&')) {
                                                        $videoId = Str::before($videoId, '&');
                                                    }
                                                    $embedUrl = 'http://www.youtube.com/embed/' . $videoId;
                                                } elseif (Str::contains($originalUrl, 'youtu.be/')) {
                                                    $videoId = Str::afterLast($originalUrl, 'youtu.be/');
                                                    if (Str::contains($videoId, '?')) {
                                                        $videoId = Str::before($videoId, '?');
                                                    }
                                                    $embedUrl = 'http://www.youtube.com/embed/' . $videoId;
                                                } elseif (Str::contains($originalUrl, 'youtube.com/embed/')) {
                                                    $embedUrl = $originalUrl;
                                                }
                                                $embedUrl .= '?autoplay=0&mute=0&controls=1'; // Sesuaikan sesuai keinginan Anda
                                            }
                                            // Deteksi PDF
                                            elseif (Str::endsWith(Str::lower($originalUrl), '.pdf')) {
                                                // Tidak perlu embedUrl, langsung gunakan originalUrl untuk asset
                                            }
                                        @endphp

                                        @if($isYouTubeVideo && $embedUrl)
                                            <div class="mb-3">
                                                <p class="text-gray-600">🎥 Video Pembelajaran:</p>
                                                <div class="aspect-w-16 aspect-h-9">
                                                    <iframe src="{{ $embedUrl }}"
                                                            class="w-full h-64 rounded-md"
                                                            frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                </div>
                                            </div>
                                        @elseif(Str::endsWith(Str::lower($originalUrl), '.pdf'))
                                            <div>
                                                <p class="text-gray-600 mb-1">📄 PDF Materi:</p>
                                                <a href="{{ asset('storage/' . $originalUrl) }}" target="_blank" class="text-blue-600 hover:underline">
                                                    Download PDF Point
                                                </a>
                                            </div>
                                        @elseif($originalUrl)
                                            <p class="text-gray-600">Konten tidak dikenali atau tidak memiliki format yang didukung (bukan video YouTube atau PDF).</p>
                                        @else
                                            <p class="text-gray-600">Tidak ada konten multimedia untuk poin ini.</p>
                                        @endif
                                    @else
                                        <p class="text-gray-600">Tidak ada konten multimedia untuk poin ini.</p>
                                    @endif
                                </div>
                            </div>
                            {{-- END: Struktur baru untuk setiap poin sebagai dropdown --}}
                        @endforeach
                    @else
                        <p class="text-gray-600 mt-4">Belum ada poin pembelajaran aktif untuk modul ini.</p>
                    @endif
                </div>
            </div>
        @else
            <p class="text-gray-600">Modul tidak ditemukan atau tidak tersedia.</p>
        @endif
    </div>

    <script>
        function toggleContent(id) {
            const content = document.getElementById(id);
            if (content) {
                content.classList.toggle('hidden');
            }
        }
    </script>
</x-app-layout>