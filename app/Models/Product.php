<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'weight',
        'pcs',
        'price',
        'stock',
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

    public function detail()
    {
        return $this->weight . ' gram, ' . $this->pcs . ' pcs';
    }
}
