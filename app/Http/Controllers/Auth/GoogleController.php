<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User; // Asumsi Anda menggunakan model User default
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Untuk membuat password acak

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['google_login' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }

        // Cek apakah user sudah ada di database berdasarkan google_id
        $existingUser = User::where('google_id', $user->id)->first();

        if ($existingUser) {
            // Jika user sudah ada, login kan
            Auth::login($existingUser);
        } else {

            // Jika user belum ada, cek berdasarkan email
            $userByEmail = User::where('email', $user->email)->first();
            if ($userByEmail) {
                // Jika ada user dengan email yang sama tapi belum terhubung Google ID
                // Update user tersebut dengan Google ID
                $userByEmail->google_id = $user->id;
                $userByEmail->avatar = $user->avatar; // Simpan avatar jika ada
                $userByEmail->save();
                Auth::login($userByEmail);
            } else {
                // Jika user baru, buat user baru di database
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'avatar' => $user->avatar, // Simpan avatar jika ada
                    'password' => Hash::make(Str::random(16)), // Buat password acak
                    'email_verified_at' => now(), // Verifikasi email karena dari Google
                ]);
                Auth::login($newUser);
            }
        }

        return redirect()->intended('/dashboard'); // Arahkan ke dashboard atau halaman yang diinginkan
    }

    /**
     * Logout user.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}