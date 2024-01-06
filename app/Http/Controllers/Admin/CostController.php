<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Setting;
use App\Services\Rajaongkir;
use Illuminate\Http\Request;

class CostController extends Controller
{
    public function index(Request $request)
    {
        $storeCity = Setting::where('setting', 'store_city')->first();
        $city = City::where('id', $storeCity->tool1)->first();

        return view('admin.cost.index', compact('city'));
    }

    public function check(Request $request)
    {
        $request->validate([
            'start_city' => 'required',
            'end_city' => 'required',
            'weight' => 'required',
            'ekspedisi' => 'required',
        ]);

        $cost = Rajaongkir::cost($request->start_city, $request->end_city, $request->weight, $request->ekspedisi);
        $data = json_decode($cost, true);
        $data = $data['rajaongkir']['results'][0];
        return $data;
    }
}