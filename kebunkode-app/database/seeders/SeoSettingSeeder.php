<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\SeoSetting;
use Illuminate\Database\Seeder;

class SeoSettingSeeder extends Seeder
{
    public function run(): void
    {
        $appUrl = config('app.url', 'http://localhost');
        $siteName = 'KebunKode';

        $organization = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $siteName,
            'url' => $appUrl,
            'description' => 'Koleksi website dan web app siap pakai untuk membantu kebutuhan sehari-hari.',
            'sameAs' => [],
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $website = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $siteName,
            'url' => $appUrl,
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => $appUrl . '/?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        SeoSetting::updateOrCreate(
            ['page_key' => 'global'],
            [
                'page_label' => 'Pengaturan Global',
                'meta_title' => 'KebunKode — Petik solusi digitalmu',
                'meta_description' => 'KebunKode menyediakan koleksi website dan web app siap pakai untuk membantu kebutuhan sehari-hari. Sederhana, rapi, dan bisa dikembangkan.',
                'meta_keywords' => 'kebunkode, website siap pakai, web app, template website, aplikasi bisnis, aplikasi produktivitas',
                'robots' => 'index, follow',
                'canonical_url' => $appUrl,
                'og_title' => 'KebunKode — Petik solusi digitalmu',
                'og_description' => 'Koleksi website dan web app siap pakai untuk membuat pekerjaan sehari-hari lebih ringan, rapi, dan menyenangkan.',
                'og_type' => 'website',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'KebunKode — Petik solusi digitalmu',
                'twitter_description' => 'Koleksi website dan web app siap pakai untuk kebutuhan sehari-hari.',
                'twitter_site' => '@kebunkode',
                'structured_data' => $organization,
                'google_analytics_id' => null,
                'google_tag_manager_id' => null,
                'google_site_verification' => null,
                'robots_txt' => "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /login\n\nSitemap: " . $appUrl . "/sitemap.xml",
                'sitemap_frequency' => 'weekly',
                'sitemap_priority' => 0.8,
            ]
        );

        SeoSetting::updateOrCreate(
            ['page_key' => 'home'],
            [
                'page_label' => 'Halaman Beranda',
                'meta_title' => 'KebunKode — Petik solusi digitalmu',
                'meta_description' => 'Temukan koleksi website dan web app siap pakai untuk produktivitas, bisnis, dan kebutuhan digitalmu. Siap pakai dan bisa dikembangkan.',
                'meta_keywords' => 'website siap pakai, web app, template website, aplikasi bisnis, aplikasi produktivitas, kebunkode',
                'robots' => 'index, follow',
                'canonical_url' => $appUrl,
                'og_title' => 'KebunKode — Petik solusi digitalmu',
                'og_description' => 'Temukan koleksi website dan web app siap pakai untuk produktivitas, bisnis, dan kebutuhan digitalmu.',
                'og_type' => 'website',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'KebunKode — Petik solusi digitalmu',
                'twitter_description' => 'Koleksi website dan web app siap pakai untuk kebutuhan sehari-hari.',
                'twitter_site' => '@kebunkode',
                'structured_data' => $website,
                'sitemap_frequency' => 'weekly',
                'sitemap_priority' => 1.0,
            ]
        );

        Product::all()->each(function (Product $product) {
            $product->update([
                'meta_title' => $product->meta_title ?: ($product->name . ' — KebunKode'),
                'meta_description' => $product->meta_description ?: mb_substr($product->description, 0, 155),
                'meta_keywords' => $product->meta_keywords ?: strtolower(implode(', ', array_filter([
                    $product->name,
                    $product->category,
                    'kebunkode',
                    'web app',
                ]))),
            ]);
        });
    }
}
