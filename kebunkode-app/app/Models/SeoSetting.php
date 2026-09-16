<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SeoSetting extends Model
{
    protected $fillable = [
        'page_key', 'page_label',
        'meta_title', 'meta_description', 'meta_keywords',
        'robots', 'canonical_url',
        'og_title', 'og_description', 'og_image', 'og_type',
        'twitter_card', 'twitter_title', 'twitter_description', 'twitter_image', 'twitter_site',
        'structured_data',
        'google_analytics_id', 'google_site_verification', 'google_tag_manager_id',
        'robots_txt', 'sitemap_frequency', 'sitemap_priority',
    ];

    protected $casts = [
        'sitemap_priority' => 'float',
    ];

    protected static function booted(): void
    {
        static::saved(fn (self $setting) => Cache::forget("seo.{$setting->page_key}"));
        static::deleted(fn (self $setting) => Cache::forget("seo.{$setting->page_key}"));
    }

    public static function get(string $pageKey): ?self
    {
        return Cache::rememberForever("seo.{$pageKey}", function () use ($pageKey) {
            return static::where('page_key', $pageKey)->first();
        });
    }

    public static function forgetAll(): void
    {
        static::all()->each(fn (self $s) => Cache::forget("seo.{$s->page_key}"));
        Cache::forget('seo.global');
    }
}
