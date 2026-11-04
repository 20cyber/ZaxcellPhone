<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AkunController extends Controller
{
    /**
     * Daftar akun admin.
     */
    public function index(): View
    {
        return view('admin.akun.index', [
            'akun' => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Form tambah akun admin baru (FA-10).
     */
    public function create(): View
    {
        return view('admin.akun.create');
    }

    /**
     * Simpan akun admin baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        return redirect()->route('admin.akun.index')->with('status', 'Akun admin baru berhasil ditambahkan.');
    }
}
