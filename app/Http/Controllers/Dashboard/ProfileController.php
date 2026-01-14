<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.pages.profile', [
            'user' => $request->user(),
            'activeMenu' => 'profile'
        ]);
    }
    public function user(Request $request)
    {
        return view('profile', [
            'user' => $request->user(),
            'activeMenu' => 'profile'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->user()->id,
        ]);

        $user = $request->user();
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profile berhasil diperbarui');
    }
}