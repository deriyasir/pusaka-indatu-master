<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    public static function getCost($origin, $destination, $weight, $courier = 'jne')
    {
        $alamat = UserAddress::find($destination);

        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_KEY'),
        ])->asForm()->post(env('RAJAONGKIR_URL') . '/cost', [
            'origin' => $origin,
            'destination' => $alamat->kota_id,
            'weight' => $weight,
            'courier' => $courier,
        ]);

        return $response->json();
    }

    public static function getProvince()
    {
        $url = env('RAJAONGKIR_URL') . '/province';
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_KEY'),
        ])->get($url);

        return $response->json();
    }

    public static function getCity($provinceId)
    {
        $url = env('RAJAONGKIR_URL') . '/city';
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_KEY'),
        ])->get($url, [
            'province' => $provinceId,
        ]);

        return $response->json();
    }
}
