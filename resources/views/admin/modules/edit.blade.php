<!-- resources/views/admin/modules/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Modul
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Notifikasi sukses -->
            @if (session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error validasi -->
            @if ($errors->any())
                <div class="mb-4">
                    <ul class="text-sm text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.modules.update', $module->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Nama Modul -->
                    <div class="mb-4">
                        <label for="name" class="block font-medium text-sm text-gray-700">Nama Modul</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $module->name) }}"
                               class="form-input rounded-md shadow-sm mt-1 block w-full"
                               required>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label for="description" class="block font-medium text-sm text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description"
                                  class="form-textarea rounded-md shadow-sm mt-1 block w-full"
                                  rows="4">{{ old('description', $module->description) }}</textarea>
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-start gap-4">
                        <x-primary-button>Simpan Perubahan</x-primary-button>
                        <a href="{{ route('admin.modules.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
