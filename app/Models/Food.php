<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'name',
        'slug',
        'price',
        'satuan',
        'description',
        'image',
        'views'
    ];

    public function scopeFilter($query)
    {
        if (request()->has('cari')) {
            return $query->where('name', 'like', '%' . request('cari') . '%')
                ->orWhere('description', 'like', '%' . request('cari') . '%');
        }
    }
}
