<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'order_id',
        'mt_order_id',
        'mt_transaction_id',
        'transaction_status',
        'status_message',
        'payment_type',
        'payment_code',
        'store',
        'settlement_time',
        'response',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
