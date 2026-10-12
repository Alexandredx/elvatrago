<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute(): string
    {
        if (empty($this->image_path)) {
            return 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80';
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        // Si ya está en uploads/ (almacenado directamente en public/uploads/products)
        if (str_starts_with($this->image_path, 'uploads/')) {
            return asset($this->image_path);
        }

        // Si existe directamente en la carpeta public
        if (file_exists(public_path($this->image_path))) {
            return asset($this->image_path);
        }

        // Si la ruta ya tiene storage/
        if (str_starts_with($this->image_path, 'storage/')) {
            return asset($this->image_path);
        }

        return asset($this->image_path);
    }
}
