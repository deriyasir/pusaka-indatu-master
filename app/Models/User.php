<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeFilter($query)
    {
        if (request()->has('cari')) {
            return $query->where('name', 'like', '%' . request('cari') . '%')
                ->orWhere('email', 'like', '%' . request('cari') . '%');
        }
    }

    public function alamat()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function getCartTotal()
    {
        $total = 0;
        foreach ($this->cart as $cart) {
            $total += $cart->getHarga();
        }

        return $total;
    }

    public function getCartWeight()
    {
        $total = 0;
        foreach ($this->cart as $cart) {
            $total += $cart->getBerat();
        }

        return $total;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
