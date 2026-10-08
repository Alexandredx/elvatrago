<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'return_number',
        'order_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'reason',
        'details',
        'status',
        'refund_amount',
        'admin_notes',
    ];

    protected $casts = [
        'refund_amount' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
