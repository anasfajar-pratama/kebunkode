<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Seo;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load('images');

        $seo = Seo::make('product', [
            'meta_title' => $product->meta_title ?: ($product->name . ' — ' . config('app.name')),
            'meta_description' => $product->meta_description ?: $product->description,
            'meta_keywords' => $product->meta_keywords,
            'og_title' => $product->meta_title ?: $product->name,
            'og_description' => $product->meta_description ?: $product->description,
            'og_image' => $product->og_image ?: optional($product->images->first())->url,
            'og_type' => 'product',
            'canonical_url' => route('product.show', $product),
            'structured_data' => $this->productSchema($product),
        ]);

        return view('product.show', compact('product', 'seo'));
    }

    private function productSchema(Product $product): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => $product->long_description ?: $product->description,
            'category' => $product->category,
            'url' => route('product.show', $product),
        ];

        if ($product->price_display) {
            $schema['offers'] = [
                '@type' => 'Offer',
                'priceCurrency' => 'IDR',
                'price' => preg_replace('/[^0-9]/', '', $product->price_display),
                'availability' => 'https://schema.org/InStock',
                'url' => route('product.show', $product),
            ];
        }

        $image = $product->og_image ?: optional($product->images->first())->url;
        if ($image) {
            $schema['image'] = Seo::imageUrl($image);
        }

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
