<?php

namespace App\Support;

use App\Models\SeoSetting;

class Seo
{
    public static function make(string $pageKey = 'global', array $overrides = []): array
    {
        $global = SeoSetting::get('global');
        $page = $pageKey !== 'global' ? SeoSetting::get($pageKey) : $global;

        $pick = function (string $field, $default = null) use ($overrides, $page, $global) {
            if (array_key_exists($field, $overrides) && $overrides[$field] !== null && $overrides[$field] !== '') {
                return $overrides[$field];
            }
            return $page?->{$field} ?? $global?->{$field} ?? $default;
        };

        $title = $pick('meta_title', config('app.name', 'KebunKode'));
        $description = $pick('meta_description');
        $ogImage = $pick('og_image');

        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $pick('meta_keywords'),
            'robots' => $pick('robots', 'index, follow'),
            'canonical' => $pick('canonical_url') ?: url()->current(),
            'og_type' => $pick('og_type', 'website'),
            'og_title' => $pick('og_title') ?: $title,
            'og_description' => $pick('og_description') ?: $description,
            'og_image' => $ogImage,
            'og_url' => url()->current(),
            'twitter_card' => $pick('twitter_card', 'summary_large_image'),
            'twitter_title' => $pick('twitter_title') ?: ($pick('og_title') ?: $title),
            'twitter_description' => $pick('twitter_description') ?: ($pick('og_description') ?: $description),
            'twitter_image' => $pick('twitter_image') ?: $ogImage,
            'twitter_site' => $pick('twitter_site'),
            'structured_data' => $pick('structured_data'),
            'google_analytics_id' => $global?->google_analytics_id,
            'google_site_verification' => $global?->google_site_verification,
            'google_tag_manager_id' => $global?->google_tag_manager_id,
        ];
    }

    public static function imageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }
        return asset('storage/' . ltrim($path, '/'));
    }
}
