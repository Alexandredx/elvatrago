<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'total_amount',
        'payment_method',
        'payment_reference',
        'payment_id',
        'status',
    ];

    public function getPaymentMethodNameAttribute(): string
    {
        return match($this->payment_method) {
            'yape' => 'Yape',
            'tarjeta' => 'Tarjeta de Débito / Crédito',
            default => ucfirst($this->payment_method ?? 'Tarjeta'),
        };
    }

    public function getStatusStepAttribute(): int
    {
        return match($this->status) {
            'confirmed', 'pending' => 1,
            'reviewed' => 2,
            'data_confirmed' => 3,
            'shipped', 'processing' => 4,
            'delivered', 'completed' => 5,
            default => 1,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'confirmed', 'pending' => 'Pedido Confirmado',
            'reviewed' => 'Revisado por el personal',
            'data_confirmed' => 'Confirmación de sus datos',
            'shipped', 'processing' => 'Enviado',
            'delivered', 'completed' => 'Entregado',
            'cancelled' => 'Cancelado',
            default => ucfirst($this->status),
        };
    }

    public function getStatusBadgeStyleAttribute(): string
    {
        return match($this->status) {
            'confirmed', 'pending' => 'background: rgba(59, 130, 246, 0.2); border: 1px solid rgba(59, 130, 246, 0.5); color: #60a5fa;',
            'reviewed' => 'background: rgba(168, 85, 247, 0.2); border: 1px solid rgba(168, 85, 247, 0.5); color: #c084fc;',
            'data_confirmed' => 'background: rgba(245, 158, 11, 0.2); border: 1px solid rgba(245, 158, 11, 0.5); color: #fbbf24;',
            'shipped', 'processing' => 'background: rgba(6, 182, 212, 0.2); border: 1px solid rgba(6, 182, 212, 0.5); color: #22d3ee;',
            'delivered', 'completed' => 'background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.5); color: #34d399;',
            'cancelled' => 'background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.5); color: #f87171;',
            default => 'background: rgba(148, 163, 184, 0.2); border: 1px solid rgba(148, 163, 184, 0.5); color: #cbd5e1;',
        };
    }

    public function getStatusBadgeIconAttribute(): string
    {
        return match($this->status) {
            'confirmed', 'pending' => 'check-circle',
            'reviewed' => 'user-check',
            'data_confirmed' => 'shield',
            'shipped', 'processing' => 'truck',
            'delivered', 'completed' => 'home',
            'cancelled' => 'x-circle',
            default => 'clock',
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function returnRequests()
    {
        return $this->hasMany(ReturnRequest::class);
    }
}

