<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ModuleController; // Controller untuk CRUD Modul Admin
use App\Http\Controllers\PaymentController; // Controller untuk Pembayaran
use App\Http\Controllers\DashboardController; // Controller Dashboard Pengguna & showModule
use App\Http\Controllers\Admin\ModuleApprovalController; // Controller untuk Approval Modul Admin
use App\Http\Controllers\Admin\ModulePointController; // Controller untuk CRUD Point Modul Admin
use App\Http\Controllers\ModuleDetailController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\user\ResearchUserController;
use App\Http\Controllers\UserModuleController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\NewsUserController;
use App\Http\Controllers\Auth\GoogleController;


// Pastikan mengimport namespace 'User' jika kamu memiliki PaymentStatusController di dalamnya
// Jika tidak, hapus saja baris ini:
// use App\Http\Controllers\User;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rute untuk Halaman Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Mengimpor Rute Otentikasi (login, register, dll.) dari file terpisah
require __DIR__.'/auth.php';

// Grup Rute Admin
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard Admin, menampilkan daftar modul yang perlu disetujui
    Route::get('/dashboard', [ModuleApprovalController::class, 'index'])->name('admin.dashboard');

    // Rute untuk menyetujui atau menolak modul
    Route::put('/module-approvals/{userModule}', [ModuleApprovalController::class, 'approve'])->name('admin.module-approvals.update');
    Route::delete('/module-approvals/{userModule}', [ModuleApprovalController::class, 'reject'])->name('admin.module-approvals.destroy');

    // Rute untuk CRUD Modul Utama (oleh Admin)
    Route::get('modules', [ModuleController::class, 'index'])->name('admin.modules.index');
    Route::get('modules/create', [ModuleController::class, 'create'])->name('admin.modules.create');
    Route::post('modules', [ModuleController::class, 'store'])->name('admin.modules.store');
    // Jika kamu memiliki edit/update/delete untuk modul utama, tambahkan di sini:
     Route::get('modules/{module}/edit', [ModuleController::class, 'edit'])->name('admin.modules.edit');
    Route::put('modules/{module}', [ModuleController::class, 'update'])->name('admin.modules.update');
     Route::delete('modules/{module}', [ModuleController::class, 'destroy'])->name('admin.modules.destroy');


//crud research

route::get('create.research', [ResearchController::class, 'create'])->name('create.research');
route::post('store.research', [ResearchController::class, 'store'])->name('store.research');
route::get('admin/research',[ResearchController::class, 'index'])->name('admin.research');
Route::get('research/{research}/edit', [ResearchController::class, 'edit'])->name('research.edit');
Route::put('research/{research}', [ResearchController::class, 'update'])->name('research.update');
route::delete('research.destroy/{research}', [ResearchController::class, 'destroy'])->name('research.destroy');

//crud blognews
route::get('admin.news', [NewsController::class, 'index'])->name('admin.news');
route::get('admin.news.create', [NewsController::class, 'create'])->name('admin.news.create');
route::post('admin.news.store', [NewsController::class, 'store'])->name('admin.news.store');
Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('admin.news.edit');
Route::get('/admin/news/{news}', [NewsController::class, 'show'])->name('admin.news.show');
route::put('/news{news}', [NewsController::class, 'update'])->name('admin.news.update');
route::delete('/admin/news{news}/destroy', [NewsController::class, 'destroy'])->name('admin.news.destroy');

    // Rute untuk CRUD Point Modul (oleh Admin)
    Route::get('modules/{module}/points', [ModulePointController::class, 'index'])->name('admin.modules.points.index');
    Route::get('modules/{module}/points/create', [ModulePointController::class, 'create'])->name('admin.modules.points.create');
    Route::post('modules/{module}/points', [ModulePointController::class, 'store'])->name('admin.modules.points.store');
    Route::get('modules/{module}/points/{point}/edit', [ModulePointController::class, 'edit'])->name('admin.modules.points.edit');
    Route::put('modules/{module}/points/{point}', [ModulePointController::class, 'update'])->name('admin.modules.points.update');
    Route::delete('modules/{module}/points/{point}', [ModulePointController::class, 'destroy'])->name('admin.modules.points.destroy');
   
});


// Grup Rute Pengguna Terautentikasi dan Terverifikasi
Route::middleware(['auth', 'verified', 'payment.check'])->group(function () {

    // Dashboard Pengguna
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//menampilkan points
Route::get('/modules/{module}', [ModuleDetailController::class, 'detailPoints'])->name('module.detail');

Route::get('/all-class', [UserModuleController::class, 'allClasses'])->name('all.class');

Route::post('/modules/{module}/points/{point}/complete', [ModuleDetailController::class, 'markPointAsComplete'])->name('points.complete');


    // Rute untuk Menampilkan Detail Modul dan Poin-poinnya
    // ***PERBAIKAN UTAMA DI SINI: MENGGUNAKAN ID MODUL BUKAN SLUG***
    Route::get('/modules/{module}/points/{point}', [ModuleDetailController::class, 'detailPoints'])->name('detail.points');

    // Rute Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute Pemilihan Modul
    Route::get('/select_module', [ModuleController::class, 'select'])->name('select_module');
    Route::post('/select_module/process', [ModuleController::class, 'processSelection'])->name('select_module.process');

    // Rute Pembayaran Modul
    Route::get('/payment/lifetime', [PaymentController::class, 'showLifetimePaymentForm'])->name('payment.lifetime');
    Route::get('/payment/yearly', [PaymentController::class, 'showYearlyPaymentForm'])->name('payment.yearly');
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');

    // Rute Status Pembayaran (jika masih digunakan, pastikan User\PaymentStatusController ada)
    // Contoh jika PaymentStatusController ada di App\Http\Controllers\User\:
    // Route::get('/payment/status', [User\PaymentStatusController::class, 'status'])->name('payment.status');
//crud researc user
route::get('research.class', [ResearchUserController::class, 'index'])->name('research.class');

//route news user

Route::get('/news', [NewsUserController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsUserController::class, 'show'])->name('news.show');


    // Rute untuk Area Member/Konten Modul yang Dilindungi (INI SEKARANG TIDAK BEGITU DIBUTUHKAN JIKA MENGGUNAKAN modules.show)
    // Kamu bisa hapus ini jika hanya ingin menggunakan '/modules/{id}' sebagai akses konten utama.
    Route::get('/member_area_approved', function() {
        return view('user.approved_modul');
    })->name('member_area_approved');

    // Tambahkan rute konten atau fitur lain yang memerlukan modul aktif di sini
});

Route::get('/auth/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Rute Halaman Modul Kedaluwarsa/Tidak Aktif
Route::get('/subscription-expired', function () {
    return view('module.select'); // Ini mungkin harusnya view 'expired' atau semacamnya
})->name('subscription.expired');