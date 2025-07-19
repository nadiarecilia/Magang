<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PelamarProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
{
    return view('frontend.home'); 
}

    public function register(Request $request)
{
    $request->validate([
        'fullName' => 'required|string|max:255',
        'firstName' => 'required|string|max:100',
        'lastName' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $request->fullName,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'pelamar', // ✅ lowercase
    ]);

    $user->assignRole('Pelamar'); // pastikan 'Pelamar' ini ada di spatie:roles

    PelamarProfile::create([
        'user_id' => $user->id,
        'first_name' => $request->firstName,
        'last_name' => $request->lastName,
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect('/')->with('success', 'Akun berhasil dibuat dan login.');
}
   public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $field = filter_var($credentials['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (Auth::attempt([$field => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Berhasil login.');
        }

        return back()->withErrors(['login' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}