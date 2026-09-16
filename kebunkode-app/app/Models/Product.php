<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'category', 'tag', 'description',
        'preview_color', 'icon', 'preview_label', 'preview_title',
        'is_dark_preview', 'long_description', 'features', 'audiences',
        'tech_stack', 'pricing', 'faq', 'meta_pills',
        'price_display', 'price_note', 'is_active',
        'meta_title', 'meta_description', 'meta_keywords', 'og_image',
    ];

    protected $casts = [
        'features' => 'array',
        'audiences' => 'array',
        'tech_stack' => 'array',
        'pricing' => 'array',
        'faq' => 'array',
        'meta_pills' => 'array',
        'is_dark_preview' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
