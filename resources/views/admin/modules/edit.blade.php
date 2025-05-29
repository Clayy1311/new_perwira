<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"> {{-- Tambahkan dark mode --}}
            Edit Modul: {{ $module->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen"> {{-- Tambahkan dark mode background --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400"> {{-- Tambahkan dark mode --}}
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4">
                    <ul class="text-sm text-red-600 dark:text-red-400 space-y-1"> {{-- Tambahkan dark mode --}}
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6"> {{-- Tambahkan dark mode --}}
                <form method="POST" action="{{ route('admin.modules.update', $module->id) }}" enctype="multipart/form-data"> {{-- Tambahkan enctype untuk upload gambar --}}
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nama Modul</label> {{-- Tambahkan dark mode --}}
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $module->name) }}"
                               class="form-input rounded-md shadow-sm mt-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('name') border-red-500 @enderror" {{-- Tambahkan dark mode dan perbaiki class --}}
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Gambar Modul</label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('image') border-red-500 @enderror">
                        @error('image')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror

                        @if ($module->image)
                            <div class="mt-4">
                                <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gambar Saat Ini:</span>
                                <img src="{{ asset('storage/' . $module->image) }}" alt="{{ $module->name }}" class="w-32 h-32 object-cover rounded-md border border-gray-300 dark:border-gray-600">
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Deskripsi</label>
                        <textarea name="description" id="description"
                                  class="form-textarea rounded-md shadow-sm mt-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('description') border-red-500 @enderror" {{-- Tambahkan dark mode dan perbaiki class --}}
                                  rows="4">{{ old('description', $module->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-4"> {{-- Gunakan flex dan justify-end --}}
                        <a href="{{ route('admin.modules.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:focus:ring-offset-gray-800">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>