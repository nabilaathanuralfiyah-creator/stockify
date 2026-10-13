<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,manager,staf',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Mencegah user menghapus akun sendiri yang sedang aktif login
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun yang sedang digunakan saat ini!']);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Akun pengguna berhasil dihapus!');
    }
}