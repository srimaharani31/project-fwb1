<?php



namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();

    //         // Redirect berdasarkan role
    //         switch (auth()->user()->role) {
    //             case 'admin':
    //                 return redirect()->route('admin.dashboard');
    //             case 'owner':
    //                 return redirect()->route('owner.dashboard');
    //             default:
    //                 return redirect()->route('pelanggan.dashboard');
    //         }
    //     }

    //     return back()->withErrors([
    //         'email' => 'Email atau password salah.',
    //     ]);
    // }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard'); // atau route sesuai role
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
