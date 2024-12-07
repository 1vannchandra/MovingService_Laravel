<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                Auth::login($user);

                return redirect()->route('dashboard');
            } else {
                return redirect()->route('login')
                    ->withErrors(['password' => 'Password salah!'])
                    ->withInput();
            }
        } else {
            return redirect()->route('login')
                ->withErrors(['email' => 'Email tidak ditemukan!'])
                ->withInput();
        }
    }

    public function register(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            return redirect()->route('login')
                ->with('success', 'Registrasi berhasil.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal melakukan registrasi. Silahkan coba lagi.']);
        }
    }
}
