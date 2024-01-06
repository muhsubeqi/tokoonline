<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\BulkData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function getData(Request $request)
    {
        $search = $request->input('search.value');
        $gender = $request->genderFilter;
        $status = $request->statusFilter;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        if ($request->ajax()) {
            $data = User::where('role', '!=', 'admin')->select('*');
            return DataTables::of($data)
                ->filter(function ($query) use ($search, $gender, $status, $startDate, $endDate) {
                    if (!empty($startDate && $endDate)) {
                        $query->where(function ($q) use ($startDate, $endDate) {
                            $q->whereDate('created_at', '>=', $startDate)
                                ->whereDate('created_at', '<=', $endDate);
                        });
                    }
                    if (!empty($gender)) {
                        $query->where(function ($q) use ($gender) {
                            $q->orWhere('gender', $gender);
                        });
                    }
                    if (!empty($status)) {
                        $query->where(function ($q) use ($status) {
                            $q->orWhere('status', $status);
                        });
                    }
                    if (!empty($search)) {
                        $query->where(function ($q) use ($search) {
                            $q->orWhere('id', 'LIKE', "%$search%")
                                ->orWhere('username', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%")
                                ->orWhere('gender', 'LIKE', "%$search%")
                                ->orWhere('phone', 'LIKE', "%$search%")
                                ->orWhere('status', 'LIKE', "%$search%")
                                ->orWhere('role', 'LIKE', "%$search%");
                        });
                    }
                })
                ->addColumn('checkbox', function ($row) {
                    $content = '<input type="checkbox" name="check[]" class="check" value="' . $row->id . '">';
                    return $content;
                })
                ->editColumn('image', function ($row) {
                    $url = asset('data/user/' . $row->image);
                    $content = '';
                    if ($row->image != null) {
                        $content = '<img src="' . $url . '" border="0" class="img-rounded" style="width:70px;height:70px;" align="center" />';
                    } else {
                        $content = '<img src="' . asset('admin/dist/img/avatar5.png') . '" border="0" class="img-rounded" style="width:70px;height:70px;" align="center" />';
                    }
                    return $content;
                })
                ->editColumn('status', function ($row) {
                    $content = '';
                    $status = BulkData::status;
                    foreach ($status as $s) {
                        if ($row->status == $s['id']) {
                            $content = '<button class="btn btn-sm ' . $s['class'] . '">' . $s['name'] . '</button>';
                        }
                    }
                    return $content;
                })
                ->editColumn('gender', function ($row) {
                    $content = '';
                    if ($row->gender == 'L') {
                        $content = 'Laki laki';
                    } else {
                        $content = 'Perempuan';
                    }
                    return $content;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Klik
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button type="button" class="dropdown-item" 
                                data-toggle="modal" data-target="#modal_edit"
                                data-id="' . $row->id . '"
                                data-name="' . $row->name . '"
                                data-username="' . $row->username . '"
                                data-email="' . $row->email . '"
                                data-phone="' . $row->phone . '"
                                data-gender="' . $row->gender . '"
                                data-birthday="' . $row->birthday . '"
                                data-role="' . $row->role . '"
                                data-status="' . $row->status . '"
                                data-image="' . $row->image . '"
                                >Edit</button>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="name" value="' . $row->name . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    Delete    
                                </button>
                            </form>
                        </div>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'image', 'status', 'checkbox'])
                ->toJson();
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'nullable',
                'username' => 'required',
                'email' => 'required',
                'phone' => 'nullable',
                'gender' => 'nullable',
                'birthday' => 'nullable',
                'role' => 'required',
            ]);

            $user = new User;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make('123456');
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->birthday = $request->birthday;
            $user->role = $request->role;
            $user->status = 2;

            if ($request->has('image')) {
                $lokasi = 'data/user/';
                $image = $request->file('image');
                $extensi = $request->file('image')->extension();
                $new_image_name = 'Image' . date('YmdHis') . uniqid() . '.' . $extensi;
                $image->move(public_path($lokasi), $new_image_name);
                $user->image = $new_image_name;
            }
            $user->save();

            $data = [
                'status' => 200,
                'message' => 'Berhasil menambah data user',
            ];

        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Gagal menambah data user',
            ];
        }
        return $data;
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'id_edit' => 'required',
                'name_edit' => 'nullable',
                'username_edit' => 'required',
                'email_edit' => 'required',
                'phone_edit' => 'nullable',
                'gender_edit' => 'nullable',
                'birthday_edit' => 'nullable',
                'role_edit' => 'required',
                'status_edit' => 'required',
            ]);

            $namaImage = $request->input('image_old');

            $user = User::where('id', $request->id_edit)->first();
            $user->name = $request->name_edit;
            $user->username = $request->username_edit;
            $user->email = $request->email_edit;
            $user->phone = $request->phone_edit;
            $user->gender = $request->gender_edit;
            $user->birthday = $request->birthday_edit;
            $user->role = $request->role_edit;
            $user->status = $request->status_edit;
            if ($request->has('image_edit')) {
                $lokasi = 'data/user/';
                $image = $request->file('image_edit');
                $extensi = $request->file('image_edit')->extension();
                $new_image_name = 'Image' . date('YmdHis') . uniqid() . '.' . $extensi;
                $upload = $image->move(public_path($lokasi), $new_image_name);
                $namaImage = $new_image_name;
                if ($upload) {
                    $getImage = User::find($request->id_edit)->image;
                    if ($getImage != null) {
                        File::delete(public_path('data/user/' . $getImage));
                    }
                }

                $user->image = $namaImage;
            }
            $user->save();

            $data = [
                'status' => 200,
                'message' => 'Berhasil mengubah data user',
            ];

        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Gagal mengubah data user',
            ];
        }

        return $data;
    }

    public function delete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required'
            ]);

            $user = User::find($request->id);
            $getImage = $user->image;
            if ($getImage != null) {
                File::delete(public_path('data/user/' . $getImage));
            }
            $user->delete();

            $data = [
                'status' => 200,
                'message' => 'Berhasil menghapus data produk',
            ];
        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Gagal menghapus data produk',
            ];
        }
        return $data;
    }

    public function export(Request $request)
    {
        $gender = $request->gender_filter;
        $status = $request->status_filter;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        return Excel::download(new UsersExport($gender, $status, $startDate, $endDate), 'users.xlsx');
    }

    public function deleteAll(Request $request)
    {
        try {
            $user_id_selected = $request->input('id');
            $users = User::whereIn('id', $user_id_selected)->get();
            foreach ($users as $user) {
                $user->delete();
            }

            $data = [
                'status' => 200,
                'message' => 'Berhasil menghapus data user yang dipilih',
            ];

        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Gagal menghapus data user',
            ];
        }

        return $data;
    }
}