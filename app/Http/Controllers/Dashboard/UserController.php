<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeMenu = 'users';

        $data = User::where('role', '!=', 'admin')->get();

        confirmDelete("Yakin mau hapus user?", "data akan hilang permanen!!");
        return view('dashboard.pages.users.users', compact('activeMenu', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $activeMenu = 'users';

        return view('dashboard.pages.users.add', compact('activeMenu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'in:user,organizer'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect(route('users.index'))->with('success', 'Tambah User berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $activeMenu = 'users';
        $data = User::findOrFail($id);

        return view('dashboard.pages.users.edit', compact('activeMenu', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class . ',email,' . $id],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'in:user,organizer'],
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect(route('users.index'))->with('success', 'Edit User berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect('/dashboard/users')->with("success", "User Berhasil di hapus");
    }
}
