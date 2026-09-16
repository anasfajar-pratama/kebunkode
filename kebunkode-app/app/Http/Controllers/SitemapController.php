<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SeoSetting;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function sitemap(): Response
    {
        $global = SeoSetting::get('global');
        $home = SeoSetting::get('home');

        $urls = [];

        $urls[] = [
            'loc' => route('home'),
            'lastmod' => optional($home?->updated_at ?? $global?->updated_at)->toAtomString() ?? now()->toAtomString(),
            'changefreq' => $home?->sitemap_frequency ?: 'weekly',
            'priority' => $home?->sitemap_priority ?? 1.0,
        ];

        Product::where('is_active', true)->latest('updated_at')->get()->each(function (Product $product) use (&$urls) {
            $urls[] = [
                'loc' => route('product.show', $product),
                'lastmod' => $product->updated_at->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => 0.8,
            ];
        });

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    public function robots(): Response
    {
        $global = SeoSetting::get('global');

        $content = $global?->robots_txt;
        if (empty($content)) {
            $content = "User-agent: *\nAllow: /\nDisallow: /admin\n\nSitemap: " . route('sitemap');
        }

        return response($content, 200, ['Content-Type' => 'text/plain']);
    }
}
