<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Daftar Berita</h3>
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Dashboard
                        </a>
                        <a href="{{ route('admin.news.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            Tambah Berita Baru
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-500 text-white p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-gray-700 rounded-lg">
                            <thead>
                                <tr class="bg-gray-800 text-left text-gray-300 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6">ID</th>
                                    <th class="py-3 px-6">Judul</th>
                                    <th class="py-3 px-6">Author</th>
                                    <th class="py-3 px-6">Gambar</th>
                                    <th class="py-3 px-6">Tanggal Publikasi</th>
                                    <th class="py-3 px-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-200 text-sm font-light">
                                @forelse ($news as $item)
                                    <tr class="border-b border-gray-600 hover:bg-gray-700">
                                        <td class="py-3 px-6 whitespace-nowrap">{{ $item->id }}</td>
                                        <td class="py-3 px-6">{{ Str::limit($item->title, 50) }}</td>
                                        <td class="py-3 px-6">{{ $item->author }}</td>
                                        <td class="py-3 px-6">
                                            @if ($item->image)
                                                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-16 h-12 object-cover rounded">
                                            @else
                                                Tidak ada gambar
                                            @endif
                                        </td>
                                        <td class="py-3 px-6">{{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}</td>
                                        <td class="py-3 px-6 flex space-x-2">
                                            <a href="{{ route('admin.news.show', $item->id) }}" class="bg-gray-600 hover:bg-gray-500 text-white py-1 px-3 rounded text-xs">Lihat</a>
                                            <a href="{{ route('admin.news.edit', $item->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded text-xs">Edit</a>
                                            <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-xs">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-3 px-6 text-center">Tidak ada berita yang tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $news->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>