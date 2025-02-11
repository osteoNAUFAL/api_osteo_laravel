<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Mendapatkan semua data user
    public function index()
    {
        $users = User::all();

        return response()->json([
            'status' => 200,
            'message' => "User ditemukan",
            'data' => $users
        ]);
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
        ]);

        // Hash password sebelum disimpan
        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = User::create($validatedData);

        return response()->json([
            'message' => 'User berhasil dibuat',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'password' => $user->password,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]
        ], 201);
    }

    // Menampilkan user berdasarkan ID
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 400);
        }

        return response()->json([
            'message' => 'User ditemukan',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'password' => $user->password,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]
        ], 200);
    }

    // Mengupdate user berdasarkan ID
    public function update(Request $request, string $id)
    {
        $user = User::findorFail($id);

        $user->update($request->all());

        return response()->json([
            'message' => 'User berhasil diperbarui',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'password' => $user->password,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]
        ], 200);
    }

    // Menghapus user berdasarkan ID
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'User berhasil dihapus',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'password' => $user->password,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]
        ], 200);
    }
}
