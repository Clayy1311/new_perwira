<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Upload Research Baru
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('store.research') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center">Upload Research File</h2>

                        <div>
                            <label for="title" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Judul Research</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="pdf_file" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Pilih File PDF</label>
                            <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg
                                file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                file:bg-blue-600 dark:file:bg-blue-700 file:text-white
                                hover:file:bg-blue-700 dark:hover:file:bg-blue-800
                                text-gray-900 dark:text-gray-100">
                            @error('pdf_file')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="image_thumbnail" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Pilih Thumbnail (Gambar)</label>
                            <input type="file" name="image" id="image_thumbnail" accept="image/*" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg
                                file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                file:bg-blue-600 dark:file:bg-blue-700 file:text-white
                                hover:file:bg-blue-700 dark:hover:file:bg-blue-800
                                text-gray-900 dark:text-gray-100">
                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-4"> {{-- Gunakan flex untuk menata tombol --}}
                            <a href="{{ route('admin.research') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white font-semibold rounded-lg transition duration-200 ease-in-out shadow-md">
                                Batal
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white font-semibold rounded-lg transition duration-200 ease-in-out shadow-md">
                                Upload Research
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>