<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $cek = User::where('id', auth()->user()->id)->first();
            if ($cek->status == 1 || $cek->role == 'admin') {
                Auth::logout();
                return redirect()->route('home')->with('error', 'Gagal Login! Akun anda belum di verifikasi');
            } else if ($cek->status == 3) {
                Auth::logout();
                return redirect()->route('home')->with('error', 'Gagal Login! Akun anda tidak aktif, silahkan hubungi administrator');
            } else {
                return back()->with('success', 'Anda berhasil login dengan akun ' . $request->email);
            }
        } else {
            return back()->with('error', 'Email atau password salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'anda berhasil logout');
    }
    public function register(Request $request)
    {
        return view('homepage.user.register');
    }

    public function registerCreate(Request $request)
    {
        $request->validate([
            'name' => 'nullable',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'nullable',
            'role' => 'required',
        ]);

        $cek = User::where('email', $request->email)->first();
        if ($cek != null) {
            return redirect()->back()->with('error', "Gagal membuat akun baru, akun " . $request->email . " sudah tersedia!");
        }

        $remember_token = base64_encode($request->email);

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->remember_token = $remember_token;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->status = 1;
        $user->save();

        $storeName = Setting::where('setting', 'store_name')->first();
        $emailENV = env('MAIL_USERNAME');

        Mail::send('email', array('name' => $request->name, 'remember_token' => $remember_token), function ($pesan) use ($request, $emailENV, $storeName) {
            $pesan->to($request->email, 'Verifikasi')->subject('Verifikasi alamat email Anda');
            $pesan->from($emailENV, strtoupper($storeName->tool1));
        });

        return redirect()->route('register.supplier-member')->with('success-email', 'Akun berhasil dibuat, silahkan cek email ' . $request->email . ' untuk verifikasi');

    }

    public function verifikasi($token)
    {
        $user = User::where('remember_token', $token)->first();

        if ($user->status == '1') {
            $user->status = '2';
        }

        $user->update([
            'status' => $user->status
        ]);

        return redirect()->route('register.supplier-member')->with('success', "Verifikasi email berhasil! silahkan anda login");
    }

    public function member()
    {
        $member = User::where('role', 'member')->orderBy('id', 'DESC')->paginate(24);
        return view('homepage.user.member', compact('member'));
    }

    public function myaccount(Request $request)
    {
        return view('homepage.user.myaccount');
    }

    public function myAccountUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable',
            'username' => 'required',
            'email' => 'required',
            'phone' => 'nullable',
            'gender' => 'nullable',
            'birthday' => 'nullable',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->birthday = $request->birthday;
        $namaImage = $request->input('image_old');
        if ($request->has('image')) {
            $lokasi = 'data/user/';
            $image = $request->file('image');
            $extensi = $request->file('image')->extension();
            $new_image_name = 'Image' . date('YmdHis') . uniqid() . '.' . $extensi;
            $upload = $image->move(public_path($lokasi), $new_image_name);
            $namaImage = $new_image_name;
            if ($upload) {
                $getImage = auth()->user()->image;
                if ($getImage != null) {
                    File::delete(public_path('data/user/' . $getImage));
                }
            }
            $user->image = $namaImage;
        }

        if ($request->input('password') != null) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('myaccount')->with('success', 'Profil berhasil di update');
    }
}