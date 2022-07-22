<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'alamat',
        'kota',
        'kota_id',
        'provinsi',
        'provinsi_id',
        'kode_pos',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddress()
    {
        return $this->alamat . ', ' . $this->kota . ', ' . $this->provinsi . ', ' . $this->kode_pos;
    }
}
