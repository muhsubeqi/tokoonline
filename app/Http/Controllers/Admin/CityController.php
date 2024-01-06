<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Services\InsertRajaOngkirToDatabase;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CityController extends Controller
{
    public function index()
    {
        return view('admin.city.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search.value');
            $data = City::join('provinces as p', 'p.id', '=', 'cities.provinces_id')->orderBy('id', 'ASC')->select('cities.*', 'p.province as province');
            return DataTables::of($data)
                ->filter(function ($query) use ($search) {
                    $query->orWhere('cities.id', 'LIKE', "%$search%")
                        ->orWhere('p.province', 'LIKE', "%$search%")
                        ->orWhere('cities.type', 'LIKE', "%$search%")
                        ->orWhere('cities.city_name', 'LIKE', "%$search%")
                        ->orWhere('cities.postal_code', 'LIKE', "%$search%");
                })
                ->toJson();
        }
    }
}