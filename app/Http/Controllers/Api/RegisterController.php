<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserModel;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'nama' => 'required',
            'password' => 'required|min:5|confirmed',
            'level_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cek apakah ada file gambar
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'Gambar tidak ditemukan.'], 400);
        }

        // Simpan gambar ke storage
        $image = $request->file('image');
        $image->store('images', 'public');

        // Simpan user ke database
        $user = UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
            'image' => $request->image->hashName(),
        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'data' => $user
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal membuat user'
        ], 409);
    }
}
