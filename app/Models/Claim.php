<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'claim_number',
        'type',
        'customer_name',
        'document_type',
        'document_number',
        'customer_email',
        'customer_phone',
        'customer_address',
        'is_minor',
        'parent_name',
        'contracted_good',
        'amount_claimed',
        'order_number',
        'good_description',
        'details',
        'consumer_request',
        'status',
        'admin_response',
        'responded_at',
    ];

    protected $casts = [
        'is_minor' => 'boolean',
        'amount_claimed' => 'decimal:2',
        'responded_at' => 'datetime',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pendiente de Atención',
            'in_process' => 'En Proceso de Evaluación',
            'resolved' => 'Resuelto / Respondido',
            'rejected' => 'Improcedente / Rechazado',
            default => 'Pendiente',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => '#f59e0b',
            'in_process' => '#3b82f6',
            'resolved' => '#10b981',
            'rejected' => '#ef4444',
            default => '#6b7280',
        };
    }
}
