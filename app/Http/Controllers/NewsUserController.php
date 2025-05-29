<?php

namespace App\Http\Controllers;

use App\Models\News; // Pastikan model News diimpor
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; // Untuk formatting tanggal

class NewsUserController extends Controller
{
    /**
     * Display a listing of the news for users.
     */
    public function index()
    {
        // Ambil semua berita yang sudah dipublikasi, diurutkan dari terbaru
        // Pastikan 'published_at' tidak null dan kurang dari atau sama dengan waktu sekarang
        $news = News::whereNotNull('published_at')
                    ->where('published_at', '<=', Carbon::now())
                    ->latest('published_at') // Urutkan berdasarkan tanggal publikasi terbaru
                    ->paginate(12); // Tampilkan 12 berita per halaman

        return view('user.news.index', compact('news'));
    }

    /**
     * Display the specified news for users.
     * Menggunakan slug untuk URL yang lebih SEO-friendly.
     */
    public function show($slug)
    {
        $news = News::where('slug', $slug)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', Carbon::now())
                    ->firstOrFail(); // Temukan berita atau tampilkan 404

        return view('user.news.show', compact('news'));
    }
}