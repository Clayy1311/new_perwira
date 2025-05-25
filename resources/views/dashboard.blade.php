{{-- resources/views/dashboard.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Pesan Sukses/Error Global --}}
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 dark:bg-green-800 dark:border-green-700 dark:text-green-200" role="alert">
                            <strong class="font-bold">Berhasil!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 dark:bg-red-800 dark:border-red-700 dark:text-red-200" role="alert">
                            <strong class="font-bold">Gagal!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <h3 class="text-2xl font-bold mb-6">Status Modul Anda</h3>

                    {{-- Bagian untuk Modul Aktif (Approved) --}}
                    @if($approvedModules->isNotEmpty())
                        <h4 class="text-xl font-semibold mb-3">Modul Aktif Anda:</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                            @foreach($approvedModules as $userModule)
                                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg p-6 shadow-md flex flex-col justify-between">
                                    <div>
                                        {{-- Menggunakan nullsafe operator ?. untuk mencegah error jika module null --}}
                                        <h5 class="text-xl font-bold text-green-800 dark:text-green-300 mb-2">{{ $userModule->module?->name ?? 'Modul Tidak Ditemukan' }}</h5>
                                        <p class="text-sm text-green-700 dark:text-green-400 mb-2">Jenis: {{ $userModule->module_type === 'lifetime' ? 'Lifetime' : '1 Tahun' }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($userModule->module?->description ?? 'Deskripsi tidak tersedia.', 100) }}</p>
                                    </div>
                                    <div class="mt-4">
                                        @if($userModule->module) {{-- Memastikan modul ada sebelum membuat link --}}
                                            {{-- UBAH INI: MENGGUNAKAN ID MODUL BUKAN SLUG --}}
                                            <a href="{{ route('modules.show', $userModule->module->id) }}"
                                               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Mulai Belajar
                                            </a>
                                        @else
                                            <span class="text-red-500 text-sm">Modul tidak tersedia (Hubungi Admin)</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Bagian untuk Modul Menunggu Persetujuan (Pending) --}}
                    @if(!is_null($pendingModule))
                        <h4 class="text-xl font-semibold mb-3">Modul Menunggu Persetujuan:</h4>
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-6 shadow-md mb-8">
                            <p class="mb-1">Nama Modul: <span class="font-medium">{{ $pendingModule->module?->name ?? 'Modul Tidak Ditemukan' }}</span></p>
                            <p class="mb-1">Jenis Durasi: <span class="font-medium">{{ $pendingModule->module_type === 'lifetime' ? 'Lifetime' : '1 Tahun' }}</span></p>
                            <p class="mb-1">Tanggal Dipilih: <span class="font-medium">{{ $pendingModule->created_at->format('d M Y H:i') }}</span></p>
                            <p class="mb-0">Status Persetujuan: <span class="font-bold text-yellow-600 dark:text-yellow-400">Menunggu Persetujuan</span></p>
                            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">Mohon tunggu kabar dari kami. Anda akan menerima notifikasi setelah modul Anda disetujui.</p>
                        </div>
                    @endif

                    {{-- Bagian untuk User yang Belum Memilih Modul Sama Sekali --}}
                    @if($noModuleSelected)
                        <h4 class="text-xl font-semibold mb-3">Pilih Modul untuk Memulai:</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 shadow-md">
                            <p class="mb-4 text-gray-700 dark:text-gray-300">Anda belum memilih modul apapun. Silakan pilih modul untuk memulai pengalaman belajar Anda.</p>
                            <a href="{{ route('select_module') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Pilih Modul Sekarang
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>