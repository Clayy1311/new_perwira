<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News; // Pastikan model News diimpor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk upload/hapus gambar
use Illuminate\Support\Str; // Untuk membuat slug

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::latest()->paginate(10); // Ambil berita terbaru dengan paginasi
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:news,title',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
            'author' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public'); // Simpan di storage/app/public/news_images
            $data['image'] = $imagePath;
        }

        // Generate slug (sudah otomatis di model, tapi bisa di-override jika perlu)
        $data['slug'] = Str::slug($request->title);

        News::create($data);

        return redirect()->route('admin.news')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:news,title,' . $news->id, // Kecualikan ID saat update
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'author' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();

        // Handle image update
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $imagePath = $request->file('image')->store('news_images', 'public');
            $data['image'] = $imagePath;
        } else {
            // Pertahankan gambar lama jika tidak ada upload baru
            unset($data['image']);
        }

        // Generate slug (sudah otomatis di model, tapi bisa di-override jika perlu)
        if ($request->title !== $news->title) { // Hanya update slug jika judul berubah
            $data['slug'] = Str::slug($request->title);
        }

        $news->update($data);

        return redirect()->route('admin.news')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        // Hapus gambar terkait jika ada
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus!');
    }
}