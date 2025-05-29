<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-300">Judul Berita</label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md shadow-sm border-gray-700 bg-gray-900 text-white focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ old('title', $news->title) }}" required>
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-300">Konten Berita</label>
                            <textarea name="content" id="content" rows="10" class="mt-1 block w-full rounded-md shadow-sm border-gray-700 bg-gray-900 text-white focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>{{ old('content', $news->content) }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-300">Gambar (Biarkan kosong jika tidak ingin mengubah)</label>
                            <input type="file" name="image" id="image" class="mt-1 block w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-500 file:text-white hover:file:bg-blue-600">
                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            @if ($news->image)
                                <div class="mt-2">
                                    <p class="text-gray-400 text-sm">Gambar saat ini:</p>
                                    <img src="{{ Storage::url($news->image) }}" alt="Gambar saat ini" class="w-32 h-24 object-cover rounded mt-1">
                                </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="author" class="block text-sm font-medium text-gray-300">Author (Opsional)</label>
                            <input type="text" name="author" id="author" class="mt-1 block w-full rounded-md shadow-sm border-gray-700 bg-gray-900 text-white focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ old('author', $news->author) }}">
                            @error('author')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="published_at" class="block text-sm font-medium text-gray-300">Tanggal Publikasi (Opsional)</label>
                            <input type="date" name="published_at" id="published_at" class="mt-1 block w-full rounded-md shadow-sm border-gray-700 bg-gray-900 text-white focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d') : '') }}">
                            @error('published_at')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md">
                                Perbarui Berita
                            </button>
                            <a href="{{ route('admin.news') }}" class="ml-4 text-gray-400 hover:text-gray-200">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>