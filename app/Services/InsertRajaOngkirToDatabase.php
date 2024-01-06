<?php

namespace App\Services;

use App\Models\City;
use App\Models\Province;

class InsertRajaOngkirToDatabase
{

    public static function province()
    {
        $province = Rajaongkir::province();
        $province = json_decode($province);
        $province = $province->rajaongkir->results;

        for ($i = 0; $i < count($province); $i++) {
            $prov = new Province();
            $prov->id = $province[$i]->province_id;
            $prov->province = $province[$i]->province;
            $prov->save();
        }

        dd('berhasil');
    }
    public static function city()
    {
        $city = Rajaongkir::city();
        $city = json_decode($city);
        $city = $city->rajaongkir->results;

        for ($i = 0; $i < count($city); $i++) {
            $c = new City();
            $c->id = $city[$i]->city_id;
            $c->provinces_id = $city[$i]->province_id;
            $c->type = $city[$i]->type;
            $c->city_name = $city[$i]->city_name;
            $c->postal_code = $city[$i]->postal_code;
            $c->save();
        }

        dd('berhasil');
    }
}