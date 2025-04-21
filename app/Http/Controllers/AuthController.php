<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) { // jika sudah login, maka redirect ke halaman home
            return redirect('/');
        }
        return view('auth.login');
    }

public function postLogin(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => true,
                'message' => 'Login Berhasil',
                'redirect' => url('/')
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Login Gagal. Username atau password salah.',
            'msgField' => [
                'username' => ['Username atau password salah'],
                'password' => ['Username atau password salah']
            ]
        ]);
    }

    return redirect('login');
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        $level = LevelModel::select('level_id', 'level_nama', 'level_kode')->whereNot('level_kode', 'ADM')->get();

        return view('auth.register', [
            'level' => $level
        ]);
    }

    public function postRegister(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('level_id', 'username', 'nama', 'password');

            $user = UserModel::create([
                'level_id' => $credentials['level_id'],
                'username' => $credentials['username'],
                'nama' => $credentials['nama'],
                'password' => Hash::make($credentials['password'])
            ]);

            if ($user) {
                return response()->json([
                    'status' => true,
                    'message' => 'Registrasi berhasil, silahkan login',
                    'redirect' => url('/login')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Registrasi gagal, username sudah digunakan'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Request Bukan Ajax'
            ]);
        }
    }

    public function profile()
     {
         $user = Auth::user();
         $activeMenu = 'profile';
 
         $breadcrumb = (object) [
             'title' => 'Profil Pengguna',
             'list'  => ['Home', 'Profil']
         ];
 
         return view('profile.index', compact('user', 'activeMenu', 'breadcrumb'))->with([
             'status' => true,
             'data' => $user
         ]);
     }
 
     public function update(Request $request)
     {
         $user = Auth::user();
 
         $rules = [
             'username' => 'required|string|min:3|unique:m_user,username,' . $user->user_id . ',user_id',
             'nama' => 'required|string|max:100',
             'password' => 'nullable|min:6|confirmed',
             'profile_picture' => 'nullable|mimes:jpeg,png,jpg|max:2048',
         ];
 
         $validator = Validator::make($request->all(), $rules);
 
         if ($validator->fails()) {
             return redirect()->back()
                 ->withErrors($validator)
                 ->withInput();
         }
 
         $user->username = $request->username;
         $user->nama = $request->nama;
 
         if ($request->filled('password')) {
             $user->password = bcrypt($request->password);
         }
 
         if ($request->hasFile('profile_picture')) {
             $file = $request->file('profile_picture');
             $filename = time() . '.' . $file->getClientOriginalExtension();
             $file->move(public_path('uploads/profile'), $filename);
             $user->profile_picture = $filename;
         }
 
         /** @var \App\Models\User $user **/
         $user->save();
 
         return redirect()->route('profile')
             ->with('success', 'Profil berhasil diperbarui');
     }
 }