<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('module_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade'); // Foreign key ke tabel modules
            $table->string('title'); // Judul point (misal: "Pengenalan Bitcoin")
            $table->integer('order')->default(1); // Urutan point dalam modul
            $table->enum('type', ['video', 'pdf', 'text', 'image', 'other']); // Tipe konten
            $table->text('content_url')->nullable(); // Untuk URL video/PDF/gambar (path file)
            $table->longText('content_text')->nullable(); // Untuk konten teks (jika type='text')
            $table->boolean('is_active')->default(true); // Apakah point ini aktif/bisa diakses
            $table->timestamps();

            // Menambahkan index untuk module_id dan order agar query lebih cepat
            $table->index(['module_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_points');
    }
};