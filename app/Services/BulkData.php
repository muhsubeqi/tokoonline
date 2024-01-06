<?php

namespace App\Services;

class BulkData
{
    public const statusPembayaran = [
        ['id' => '1', 'name' => 'Belum Lunas'],
        ['id' => '2', 'name' => 'Menunggu'],
        ['id' => '3', 'name' => 'Dikirim'],
        ['id' => '4', 'name' => 'Selesai'],
    ];

    public const gender = [
        ['alias' => 'L', 'name' => 'Laki laki'],
        ['alias' => 'P', 'name' => 'Perempuan']
    ];

    public const status = [
        ['id' => '1', 'name' => 'Pending', 'class' => 'bg-secondary'],
        ['id' => '2', 'name' => 'Aktif', 'class' => 'bg-success'],
        ['id' => '3', 'name' => 'Tidak Aktif', 'class' => 'bg-danger']
    ];


}