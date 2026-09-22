<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Memproses login
     */
    public function auth(LoginRequest $request)
    {
        $credentials = $request->validated();
        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withErrors([
                    'email' => "Login diblokir sementara. Coba lagi dalam {$seconds} detik.",
                ])
                ->withInput($request->only('email'));
        }

        if (Auth::attempt($credentials)) {

            RateLimiter::clear($throttleKey);

            // Regenerasi session setelah login
            $request->session()->regenerate();

            return redirect()
                ->route('dashboard')
                ->with(
                    'success',
                    'Selamat datang, ' . Auth::user()->name . '!'
                );
        }

        RateLimiter::hit($throttleKey, 60);

        $message = 'Email atau password tidak valid.';
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $message = "Tiga kali percobaan gagal. Login diblokir selama {$seconds} detik.";
        }

        return back()
            ->withErrors([
                'email' => $message,
            ])
            ->withInput($request->only('email'));
    }

    private function throttleKey(Request $request): string
    {
        return strtolower((string) $request->input('email')) . '|' . $request->ip();
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus session
        $request->session()->invalidate();

        // Buat token CSRF baru
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda telah keluar dari aplikasi.');
    }
}