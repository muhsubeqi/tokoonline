<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataUser;
use App\Models\User;
use App\Http\Services\BulkData;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private $folder = 'admin/profile';
    public function index()
    {
        $user = User::where('id', auth()->user()->id)->first();

        $image = auth()->user()->image;
        return view("$this->folder/index", compact('user', 'image'));
    }

    public function edit()
    {
        $user = User::where('id', auth()->user()->id)->first();

        return view("$this->folder/edit", compact('user'));
    }

    public function update(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|max:255|email',
            ]);

            $namaImage = $request->input('image_lama');

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
            }

            if ($request->has('password')) {
                $passValidated = $request->validate([
                    'password' => 'required|max:255',
                    'konfirmasi_password' => 'required|same:password'
                ]);
                $dataValidated['password'] = $passValidated['password'];
                $dataValidated['konfirmasi_password'] = $passValidated['konfirmasi_password'];
            }

            $userId = auth()->user()->id;

            if ($request->has('password')) {
                User::where('id', $userId)
                    ->update([
                        'name' => $dataValidated['name'],
                        'email' => $dataValidated['email'],
                        'password' => Hash::make($dataValidated['password']),
                        'image' => $namaImage
                    ]);
            } else {
                User::where('id', $userId)
                    ->update([
                        'name' => $dataValidated['name'],
                        'email' => $dataValidated['email'],
                        'image' => $namaImage
                    ]);
            }
        } catch (\Throwable $th) {
            return redirect()->route('admin.profile')->with('failed', 'Gagal mengupdate profile');
        }
        return redirect()->route('admin.profile')->with('message', 'Berhasil mengupdate profile');
    }

}