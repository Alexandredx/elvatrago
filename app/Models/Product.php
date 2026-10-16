<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'short_description',
        'description',
        'price',
        'sale_price',
        'type',
        'external_url',
        'platform_name',
        'stock',
        'has_sizes',
        'size_type',
        'sizes',
        'video_url',
        'video_path',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock' => 'integer',
        'has_sizes' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order', 'asc');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function clickLogs()
    {
        return $this->hasMany(ClickLog::class);
    }

    public function isAffiliate(): bool
    {
        return $this->type === 'affiliate';
    }

    public function isDirect(): bool
    {
        return $this->type === 'direct';
    }

    public function getEffectivePriceAttribute(): float
    {
        return $this->sale_price ? (float)$this->sale_price : (float)$this->price;
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->images->where('is_primary', true)->first() ?? $this->images->first();
        if ($primary) {
            return $primary->url;
        }
        return 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80';
    }

    public function getHasSizesAttribute(): bool
    {
        if (isset($this->attributes['has_sizes']) && $this->attributes['has_sizes']) {
            return true;
        }

        if (!empty($this->attributes['sizes'])) {
            return true;
        }

        // Detección automática por categoría o palabras clave en el título
        $catSlug = $this->category->slug ?? '';
        $title = strtolower($this->title ?? '');
        if ($catSlug === 'moda-accesorios' ||
            str_contains($title, 'polo') ||
            str_contains($title, 'camiseta') ||
            str_contains($title, 'camisa') ||
            str_contains($title, 'zapatilla') ||
            str_contains($title, 'zapato') ||
            str_contains($title, 'sneaker') ||
            str_contains($title, 'pantalon') ||
            str_contains($title, 'pantalón') ||
            str_contains($title, 'jean') ||
            str_contains($title, 'short') ||
            str_contains($title, 'polera') ||
            str_contains($title, 'hoodie') ||
            str_contains($title, 'casaca')
        ) {
            return true;
        }

        return false;
    }

    public function getAvailableSizesAttribute(): array
    {
        $raw = $this->attributes['sizes'] ?? null;
        if (!empty($raw)) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded) && count($decoded) > 0) {
                return $decoded;
            }
            $parts = array_filter(array_map('trim', explode(',', $raw)));
            if (count($parts) > 0) {
                return array_values($parts);
            }
        }

        $title = strtolower($this->title ?? '');
        $type = $this->size_type;

        if ($type === 'zapatillas' || str_contains($title, 'zapatilla') || str_contains($title, 'zapato') || str_contains($title, 'sneaker') || str_contains($title, 'calzado')) {
            return ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];
        }

        if ($type === 'pantalon' || str_contains($title, 'pantalon') || str_contains($title, 'pantalón') || str_contains($title, 'jean') || str_contains($title, 'short')) {
            return ['28', '30', '32', '34', '36', '38'];
        }

        if ($this->has_sizes || ($this->category->slug ?? '') === 'moda-accesorios' || str_contains($title, 'polo') || str_contains($title, 'camiseta') || str_contains($title, 'polera') || str_contains($title, 'casaca')) {
            return ['S', 'M', 'L', 'XL', 'XXL'];
        }

        return [];
    }

    public function getHasVideoAttribute(): bool
    {
        return !empty($this->video_path) || !empty($this->video_url);
    }

    public function getVideoTypeAttribute(): ?string
    {
        if (!empty($this->video_path)) {
            return 'file';
        }
        $url = $this->video_url ?? '';
        if (preg_match('/(youtube\.com|youtu\.be)/i', $url)) {
            return 'youtube';
        }
        if (preg_match('/vimeo\.com/i', $url)) {
            return 'vimeo';
        }
        if (preg_match('/\.(mp4|webm|ogg|mov)(\?.*)?$/i', $url)) {
            return 'file_url';
        }
        return !empty($url) ? 'iframe' : null;
    }

    public function getVideoEmbedUrlAttribute(): ?string
    {
        if (!empty($this->video_path)) {
            return asset($this->video_path);
        }

        $url = $this->video_url;
        if (empty($url)) {
            return null;
        }

        // YouTube
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1] . '?autoplay=1&rel=0';
        }

        // Vimeo
        if (preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/', $url, $matches)) {
            return 'https://player.vimeo.com/video/' . $matches[3] . '?autoplay=1';
        }

        return $url;
    }

    public function getVideoFileUrlAttribute(): ?string
    {
        if (!empty($this->video_path)) {
            return asset($this->video_path);
        }
        if ($this->video_type === 'file_url') {
            return $this->video_url;
        }
        return null;
    }
}
