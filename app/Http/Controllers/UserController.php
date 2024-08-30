<?php

namespace  App\Http\Controllers;

use App\Entities\User;
use Illuminate\Http\Request;
use  Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view user', ['only' => ['index']]);
    //     $this->middleware('permission:create user', ['only' => ['create','store']]);
    //     $this->middleware('permission:update user', ['only' => ['update','edit']]);
    //     $this->middleware('permission:delete user', ['only' => ['destroy']]);
    // }

    public function index()
    {
        $users = User::all();
        return view('apps.user.index', ['users' => $users]);
    }

    public function create()
    {
        return view('apps.user.create');
    }

    public function store(Request $request)
    {
        // Validasi input yang diterima
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'role_id' => 'required|exists:roles,id', // Validasi role_id
        ]);
    
        // Membuat user baru dengan data yang diberikan
        $user = User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id, // Menyimpan role_id
        ]);
    
        // Mengatur role pada user jika Anda menggunakan Spatie Laravel Permission
        // $user->syncRoles($request->roles); // Hapus komentar jika menggunakan multiple roles
    
        // Redirect ke halaman users.index dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $id)
    {
        // $roles = Role::pluck('name', 'name')->all();
        // $userRoles = $user->roles->pluck('name', 'name')->all();
        // return view('role-permission.user.edit', [
        //     'user' => $user,
        //     'roles' => $roles,
        //     'userRoles' => $userRoles
        // ]);
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input yang diterima
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);
        $user->fullname = $request->fullname; // Memperbaiki kesalahan penamaan variabel
        $user->username = $request->username; // Menambahkan update username
        $user->email = $request->email;
        $user->role_id = $request->role_id; // Menambahkan atau memperbarui role_id

        // Cek jika password diisi, jika ya, maka hash dan simpan
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan pada user
        $user->save();

        // Redirect ke halaman users.index dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
