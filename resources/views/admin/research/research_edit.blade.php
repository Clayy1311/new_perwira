<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Research: <span class="font-bold">{{ $research->title }}</span>
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

                    <form action="{{ route('research.update', $research->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center">Edit Research File</h2>

                        <div>
                            <label for="title" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Judul Research</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $research->title) }}" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="pdf_file" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">File PDF (Biarkan kosong jika tidak ingin mengubah)</label>
                            <input type="file" name="pdf_file" id="pdf_file" accept=".pdf"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg
                                file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                file:bg-blue-600 dark:file:bg-blue-700 file:text-white
                                hover:file:bg-blue-700 dark:hover:file:bg-blue-800
                                text-gray-900 dark:text-gray-100">
                            @error('pdf_file')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            @if ($research->pdf_file)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">File PDF saat ini: <a href="{{ asset('storage/' . $research->pdf_file) }}" target="_blank" class="text-blue-500 hover:underline">Lihat PDF</a></p>
                            @endif
                        </div>

                        <div>
                            <label for="image" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Thumbnail (Biarkan kosong jika tidak ingin mengubah)</label>
                            <input type="file" name="image" id="image" accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg
                                file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                file:bg-blue-600 dark:file:bg-blue-700 file:text-white
                                hover:file:bg-blue-700 dark:hover:file:bg-blue-800
                                text-gray-900 dark:text-gray-100">
                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            @if ($research->image)
                                <div class="mt-4">
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Thumbnail Saat Ini:</span>
                                    <img src="{{ asset('storage/' . $research->image) }}" alt="{{ $research->title }}" class="w-32 h-32 object-cover rounded-md border border-gray-300 dark:border-gray-600">
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.research') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white font-semibold rounded-lg transition duration-200 ease-in-out shadow-md">
                                Batal
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white font-semibold rounded-lg transition duration-200 ease-in-out shadow-md">
                                Update Research
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>