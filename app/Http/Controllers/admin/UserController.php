<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Pastikan ini di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    
    public function index()
    {
       
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        
        abort(404); 
    }

    
    public function store(Request $request)
    {
        // Sama seperti create(), Anda bisa mengarahkan kembali atau mencegah eksekusi
        // return redirect()->route('admin.users.index')->with('error', 'Operasi penambahan pengguna baru tidak diizinkan.');
        abort(404); // Atau 403 Forbidden jika ingin lebih eksplisit
    }

    
    public function update(Request $request, User $user)
    {
        // Validasi dan logika update tetap ada
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'owner', 'pelanggan'])],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Contoh otorisasi menggunakan Gate, pastikan Anda memiliki Gate 'delete-user'
        // if (! Gate::allows('delete-user', $user)) {
        //     abort(403, 'Anda tidak memiliki izin untuk menghapus pengguna ini.');
        // }

        // Pastikan admin tidak bisa menghapus dirinya sendiri jika tidak ada admin lain
        // atau logika lain yang Anda inginkan
        if (auth()->user()->id === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna berhasil dihapus!');
    }
}