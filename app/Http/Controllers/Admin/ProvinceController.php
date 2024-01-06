<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Services\InsertRajaOngkirToDatabase;
use App\Services\Rajaongkir;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProvinceController extends Controller
{
    public function index()
    {
        return view('admin.province.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search.value');
            $data = Province::select('*');
            return DataTables::of($data)
                ->toJson();
        }
    }
}