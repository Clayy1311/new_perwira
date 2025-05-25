<div class="mb-4">
    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Point</label>
    <input type="text" name="title" id="title" value="{{ old('title', $point->title ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
    @error('title')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4 flex space-x-4">
    <div class="w-1/2">
        <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Urutan</label>
        <input type="number" name="order" id="order" value="{{ old('order', $point->order ?? $nextOrder ?? 1) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required min="1">
        @error('order')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    <div class="w-1/2">
        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe Konten</label>
        <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" onchange="toggleContentInputs()">
            <option value="video" {{ old('type', $point->type ?? '') == 'video' ? 'selected' : '' }}>Video</option>
            <option value="pdf" {{ old('type', $point->type ?? '') == 'pdf' ? 'selected' : '' }}>PDF</option>
            <option value="text" {{ old('type', $point->type ?? '') == 'text' ? 'selected' : '' }}>Teks</option>
            <option value="image" {{ old('type', $point->type ?? '') == 'image' ? 'selected' : '' }}>Gambar</option>
            <option value="other" {{ old('type', $point->type ?? '') == 'other' ? 'selected' : '' }}>Lainnya (File Download)</option>
        </select>
        @error('type')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- Dynamic Content Input --}}
<div id="content_url_input" class="mb-4" style="{{ old('type', $point->type ?? 'video') == 'text' ? 'display: none;' : '' }}">
    <label for="content_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL Konten (YouTube/Vimeo/Eksternal)</label>
    <input type="text" name="content_url" id="content_url" value="{{ old('content_url', $point->content_url ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Masukkan URL dari YouTube, Vimeo, atau link file eksternal (video, PDF, gambar).</p>
    @error('content_url')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

<div id="content_file_input" class="mb-4" style="{{ old('type', $point->type ?? 'video') == 'text' ? 'display: none;' : '' }}">
    <label for="content_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Atau Upload File Konten (Video/PDF/Gambar)</label>
    <input type="file" name="content_file" id="content_file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:text-gray-400 dark:file:bg-gray-700 dark:file:text-gray-200 dark:hover:file:bg-gray-600">
    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maks. 50MB. Format: MP4, MOV, OGG, PDF, JPG, PNG, GIF.</p>
    @error('content_file')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror

    @if (isset($point) && $point->content_url && $point->type !== 'text')
        <div class="mt-2">
            <p class="text-sm text-gray-500 dark:text-gray-400">File/URL saat ini:</p>
            @if ($point->type == 'video' || $point->type == 'pdf' || $point->type == 'image' || $point->type == 'other')
                <a href="{{ asset($point->content_url) }}" target="_blank" class="text-indigo-600 hover:underline dark:text-indigo-400">Lihat File</a>
            @endif
            <label class="mt-2 inline-flex items-center text-sm text-gray-700 dark:text-gray-300">
                <input type="checkbox" name="remove_file" value="1" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                <span class="ml-2">Hapus File/URL yang ada</span>
            </label>
        </div>
    @endif
</div>

<div id="content_text_input" class="mb-4" style="{{ old('type', $point->type ?? '') == 'text' ? '' : 'display: none;' }}">
    <label for="content_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konten Teks</label>
    <textarea name="content_text" id="content_text" rows="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('content_text', $point->content_text ?? '') }}</textarea>
    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Anda bisa memasukkan teks, termasuk HTML dasar jika diperlukan.</p>
    @error('content_text')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Point</label>
    <select name="is_active" id="is_active" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <option value="1" {{ old('is_active', $point->is_active ?? true) ? 'selected' : '' }}>Aktif</option>
        <option value="0" {{ old('is_active', $point->is_active ?? false) ? '' : 'selected' }}>Nonaktif</option>
    </select>
    @error('is_active')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

<script>
    // Fungsi untuk menampilkan/menyembunyikan input berdasarkan tipe konten
    function toggleContentInputs() {
        const type = document.getElementById('type').value;
        const urlInputDiv = document.getElementById('content_url_input');
        const fileInputDiv = document.getElementById('content_file_input');
        const textInputDiv = document.getElementById('content_text_input');

        if (type === 'text') {
            urlInputDiv.style.display = 'none';
            fileInputDiv.style.display = 'none';
            textInputDiv.style.display = 'block';
        } else {
            urlInputDiv.style.display = 'block';
            fileInputDiv.style.display = 'block';
            textInputDiv.style.display = 'none';
        }
    }

    // Panggil saat halaman dimuat untuk inisialisasi
    document.addEventListener('DOMContentLoaded', toggleContentInputs);
</script>