<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <h3 class="text-2xl font-bold mb-2">{{ $news->title }}</h3>
                        <p class="text-gray-400 text-sm">Oleh: {{ $news->author }} | Publikasi: {{ $news->published_at ? $news->published_at->format('d F Y') : '-' }}</p>
                    </div>

                    @if ($news->image)
                        <div class="mb-6">
                            <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}" class="w-full h-auto max-h-96 object-cover rounded-lg">
                        </div>
                    @endif

                    <div class="prose prose-invert max-w-none text-gray-300 mb-8">
                        {!! nl2br(e($news->content)) !!} {{-- nl2br untuk baris baru, e() untuk sanitasi --}}
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.news.edit', $news->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-md">
                            Edit Berita
                        </a>
                        <a href="{{ route('admin.news') }}" class="ml-4 text-gray-400 hover:text-gray-200">Kembali ke Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>