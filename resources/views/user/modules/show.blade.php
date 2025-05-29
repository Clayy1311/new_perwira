<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Modul: {{ $module->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-3xl font-bold mb-4">{{ $module->name }}</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-6">{{ $module->description }}</p>

                    <hr class="my-6 border-gray-200 dark:border-gray-700">

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        {{-- Sidebar / Daftar Points --}}
                        <div class="md:col-span-1 bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow">
                            <h4 class="text-xl font-bold mb-4">Daftar Pelajaran</h4>
                            <ul class="space-y-2">
                                @forelse($points as $point)
                                    <li>
                                        <a href="#"
                                           class="point-item block p-2 rounded-md hover:bg-indigo-100 dark:hover:bg-indigo-600 {{ $loop->first ? 'bg-indigo-100 dark:bg-indigo-600 text-indigo-800 dark:text-indigo-100' : 'text-gray-700 dark:text-gray-200' }}"
                                           data-type="{{ $point->type }}"
                                           data-url="{{ $point->content_url }}"
                                           data-text="{{ $point->content_text }}">
                                            {{ $point->order }}. {{ $point->title }}
                                        </a>
                                    </li>
                                @empty
                                    <li><p class="text-gray-500 dark:text-gray-400">Belum ada pelajaran tersedia untuk modul ini.</p></li>
                                @endforelse
                            </ul>
                        </div>

                        {{-- Main Content Area --}}
                        <div class="md:col-span-3 bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow">
                            <h4 id="main-content-title" class="text-xl font-bold mb-4">Pilih pelajaran untuk memulai...</h4>
                            <div id="main-content-body" class="prose dark:prose-invert max-w-none">
                                <p class="text-gray-600 dark:text-gray-300">Klik salah satu pelajaran di sisi kiri untuk melihat kontennya di sini.</p>
                                {{-- Konten akan dimuat di sini --}}
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline dark:text-indigo-400 dark:hover:text-indigo-200">Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script JavaScript untuk menampilkan konten --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pointItems = document.querySelectorAll('.point-item');
            const mainContentTitle = document.getElementById('main-content-title');
            const mainContentBody = document.getElementById('main-content-body');

            function loadContent(title, type, url, text) {
                mainContentTitle.textContent = title;
                mainContentBody.innerHTML = ''; // Kosongkan konten sebelumnya

                if (type === 'video') {
                    // Coba embed YouTube/Vimeo atau langsung video file
                    let embedHtml = '';
                    if (url.includes('youtube.com/watch?v=') || url.includes('youtu.be/')) {
                        const videoId = url.split('v=')[1] || url.split('/').pop();
                        embedHtml = `<div class="relative pb-[56.25%] h-0 overflow-hidden"><iframe src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="absolute top-0 left-0 w-full h-full"></iframe></div>`;
                    } else if (url.includes('vimeo.com/')) {
                        const videoId = url.split('/').pop();
                        embedHtml = `<div class="relative pb-[56.25%] h-0 overflow-hidden"><iframe src="https://player.vimeo.com/video/${videoId}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen class="absolute top-0 left-0 w-full h-full"></iframe></div>`;
                    } else if (url) {
                        embedHtml = `<video controls class="w-full h-auto rounded-lg"><source src="${url}" type="video/mp4">Your browser does not support the video tag.</video>`;
                    } else {
                         embedHtml = '<p class="text-red-500">Video URL tidak tersedia atau tidak valid.</p>';
                    }
                    mainContentBody.innerHTML = embedHtml;
                } else if (type === 'pdf') {
                    if (url) {
                         mainContentBody.innerHTML = `<iframe src="${url}#toolbar=0&navpanes=0&scrollbar=0" class="w-full h-[600px] border rounded-lg"></iframe><p class="mt-2"><a href="${url}" target="_blank" class="text-indigo-600 hover:underline dark:text-indigo-400">Download PDF</a></p>`;
                    } else {
                        mainContentBody.innerHTML = '<p class="text-red-500">PDF URL tidak tersedia.</p>';
                    }
                } else if (type === 'image') {
                    if (url) {
                        mainContentBody.innerHTML = `<img src="${url}" alt="${title}" class="max-w-full h-auto rounded-lg">`;
                    } else {
                        mainContentBody.innerHTML = '<p class="text-red-500">Gambar URL tidak tersedia.</p>';
                    }
                } else if (type === 'text') {
                    if (text) {
                        // Menggunakan DOMPurify untuk membersihkan HTML jika diizinkan
                        // Atau bisa langsung tampilkan text jika yakin tidak ada HTML berbahaya
                        // Untuk keamanan, sebaiknya gunakan DOMPurify atau purifikasi server-side
                        mainContentBody.innerHTML = text; // Untuk demo cepat
                        // mainContentBody.innerHTML = DOMPurify.sanitize(text); // Jika menggunakan DOMPurify
                    } else {
                        mainContentBody.innerHTML = '<p class="text-gray-600 dark:text-gray-300">Tidak ada konten teks untuk pelajaran ini.</p>';
                    }
                } else if (type === 'other') {
                    if (url) {
                         mainContentBody.innerHTML = `<p class="text-lg">Silakan unduh file konten ini:</p><a href="${url}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">Download File</a>`;
                    } else {
                        mainContentBody.innerHTML = '<p class="text-red-500">URL file tidak tersedia.</p>';
                    }
                } else {
                    mainContentBody.innerHTML = '<p class="text-gray-600 dark:text-gray-300">Tipe konten tidak dikenal.</p>';
                }
            }

            // Atur point pertama sebagai konten default saat halaman dimuat
            if (pointItems.length > 0) {
                const firstPoint = pointItems[0];
                firstPoint.classList.add('bg-indigo-100', 'dark:bg-indigo-600', 'text-indigo-800', 'dark:text-indigo-100');
                firstPoint.classList.remove('text-gray-700', 'dark:text-gray-200');
                loadContent(
                    firstPoint.textContent.trim(),
                    firstPoint.dataset.type,
                    firstPoint.dataset.url,
                    firstPoint.dataset.text
                );
            }

            // Tambahkan event listener untuk setiap point
            pointItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault(); // Hindari refresh halaman
                    // Hapus kelas aktif dari semua item
                    pointItems.forEach(pi => {
                        pi.classList.remove('bg-indigo-100', 'dark:bg-indigo-600', 'text-indigo-800', 'dark:text-indigo-100');
                        pi.classList.add('text-gray-700', 'dark:text-gray-200');
                    });
                    // Tambahkan kelas aktif ke item yang diklik
                    this.classList.add('bg-indigo-100', 'dark:bg-indigo-600', 'text-indigo-800', 'dark:text-indigo-100');
                    this.classList.remove('text-gray-700', 'dark:text-gray-200');

                    // Muat konten
                    loadContent(
                        this.textContent.trim(),
                        this.dataset.type,
                        this.dataset.url,
                        this.dataset.text
                    );
                });
            });
        });
    </script>
</x-app-layout>