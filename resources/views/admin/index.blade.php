<x-app-layout>
    <x-slot name="header bg-black">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight"> {{-- Ubah warna teks header --}}
            Manajemen Persetujuan Modul
        </h2>
    </x-slot>

    <div class="py-12 bg-[#021028] min-h-screen"> {{-- Warna background gelap --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#0f1d31] overflow-hidden shadow-xl sm:rounded-lg p-6 border border-[#1a2e4c]"> {{-- Warna container yang lebih gelap dan border --}}

                {{-- Tombol Navigasi Admin yang keren --}}
                <div class="mb-8 p-4 bg-[#0a182b] rounded-lg shadow-inner flex flex-wrap justify-center gap-4 border border-[#1a2e4c]"> {{-- Warna background tombol navigasi --}}
                    <a href="{{ route('admin.modules.index') }}" class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold rounded-lg shadow-md hover:from-blue-700 hover:to-indigo-800 transition duration-300 ease-in-out transform hover:scale-105"> {{-- Sesuaikan gradient agar lebih gelap --}}
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Kelola Modul Kelas
                    </a>
                    <a href="{{ route('admin.research') }}" class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-teal-700 text-white font-semibold rounded-lg shadow-md hover:from-green-700 hover:to-teal-800 transition duration-300 ease-in-out transform hover:scale-105"> {{-- Sesuaikan gradient agar lebih gelap --}}
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Buat Research Baru
                    </a>
                    <a href="{{ route('admin.news') }}" class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-700 text-white font-semibold rounded-lg shadow-md hover:from-purple-700 hover:to-pink-800 transition duration-300 ease-in-out transform hover:scale-105"> {{-- Sesuaikan gradient agar lebih gelap --}}
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v10m-3 0l-4-4m0 0l-4 4m4-4V3"></path></svg>
                        Buat Berita Blog
                    </a>
                </div>

                {{-- HILANGKAN TEKS "Modul Menunggu Persetujuan" --}}
                {{-- <h3 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-3">Modul Menunggu Persetujuan</h3> --}}

                {{-- Bagian untuk menampilkan pesan SUKSES --}}
                @if (session('success'))
                    <div class="bg-green-800 text-green-200 px-4 py-3 rounded relative mb-4 border border-green-700"
                        role="alert">
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Bagian untuk menampilkan pesan ERROR/PENOLAKAN --}}
                @if (session('error'))
                    <div class="bg-red-800 text-red-200 px-4 py-3 rounded relative mb-4 border border-red-700"
                        role="alert">
                        <strong class="font-bold">Gagal!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($pendingModules->isEmpty())
                    <p class="text-gray-400 text-center py-8">Tidak ada modul yang menunggu persetujuan saat ini.</p>
                @else
                    <div class="overflow-x-auto rounded-lg border border-[#1a2e4c]"> {{-- Tambahkan rounded dan border ke tabel --}}
                        <table class="min-w-full divide-y divide-[#1a2e4c]"> {{-- Garis pemisah tabel --}}
                            <thead class="bg-[#0a182b]"> {{-- Header tabel gelap --}}
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Nama Modul
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Tipe Modul
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Tanggal Pengajuan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-[#0f1d31] divide-y divide-[#1a2e4c]"> {{-- Body tabel gelap --}}
                                @foreach ($pendingModules as $module)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300"> {{-- Warna teks data --}}
                                            {{ $module->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300"> {{-- Warna teks data --}}
                                            {{ $module->module_type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400"> {{-- Warna teks data --}}
                                            {{ $module->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <form method="POST" action="{{ route('admin.module-approvals.update', $module) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs font-bold rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md"> {{-- Tombol lebih gelap --}}
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        Setujui
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.module-approvals.destroy', $module) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md"> {{-- Tombol lebih gelap --}}
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 text-gray-300"> {{-- Warna teks pagination --}}
                        {{ $pendingModules->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>