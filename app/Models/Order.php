<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'no_order',
        'address_id',
        'kurir',
        'service',
        'etd',
        'harga_ongkir',
        'resi',
        'total',
        'status',
    ];

    public function scopeFilter($query)
    {
        if (request()->has('cari')) {
            return $query->where('no_order', 'like', '%' . request('cari') . '%');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }

    public function getOrderTotal()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += ($item->product->price * $item->quantity);
        }

        return $total;
    }

    public function getOrderWeight()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += ($item->product->weight * $item->quantity);
        }

        return $total;
    }

    public function alamat()
    {
        return $this->belongsTo(UserAddress::class, 'address_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'order_id');
    }

    public function isPaid()
    {
        return $this->transactions()->where('transaction_status', 'settlement')
            ->orWhere('transaction_status', 'success')
            ->exists();
    }

    public function getStatus()
    {
        if ($this->status == 'cancelled') return '<span class="badge bg-danger">Pesanan dibatalkan</span>';
        if ($this->transactions->count() == 0 || !$this->isPaid()) return '<span class="badge bg-warning">Menunggu Pembayaran</span>';

        switch ($this->status) {
            case 'waiting':
                return '<span class="badge bg-dark">Menunggu konfirmasi Admin</span>';
                break;
            case 'processing':
                return '<span class="badge bg-info">Pesanan diproses</span>';
                break;
            case 'sending':
                return '<span class="badge bg-primary">Pesanan dikirim</span>';
                break;
            case 'done':
                return '<span class="badge bg-success">Pesanan selesai</span>';
                break;
            case 'cancelled':
                return '<span class="badge bg-danger">Pesanan dibatalkan</span>';
                break;
            default:
                return '<span class="badge bg-secondary">Pesanan Tidak Diketahui</span>';
                break;
        }
    }
}
