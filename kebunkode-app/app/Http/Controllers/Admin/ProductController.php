<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(12);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form');
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);
        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        $data['features'] = $this->parseJsonField($request->input('features_text'));
        $data['audiences'] = $this->parseJsonField($request->input('audiences_text'));
        $data['tech_stack'] = $this->parseJsonField($request->input('tech_stack_text'));
        $data['faq'] = $this->parseJsonField($request->input('faq_text'));
        $data['meta_pills'] = array_filter(array_map('trim', explode(',', $request->input('meta_pills', ''))));

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->storeOgImage($request->file('og_image'));
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $product->load('images');
        return view('admin.products.form', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request, $product);

        if ($request->input('name') !== $product->name) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        }

        $data['features'] = $this->parseJsonField($request->input('features_text'));
        $data['audiences'] = $this->parseJsonField($request->input('audiences_text'));
        $data['tech_stack'] = $this->parseJsonField($request->input('tech_stack_text'));
        $data['faq'] = $this->parseJsonField($request->input('faq_text'));
        $data['meta_pills'] = array_filter(array_map('trim', explode(',', $request->input('meta_pills', ''))));

        if ($request->hasFile('og_image')) {
            if ($product->og_image) {
                Storage::disk('public')->delete('seo/' . $product->og_image);
            }
            $data['og_image'] = $this->storeOgImage($request->file('og_image'));
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete('products/' . $image->filename);
            Storage::disk('public')->delete('products/thumbnails/' . $image->filename);
        }
        $product->images()->delete();
        if ($product->og_image) {
            Storage::disk('public')->delete('seo/' . $product->og_image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function toggle(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return back()->with('success', 'Status produk berhasil diubah.');
    }

    private function validateProduct(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:website,produktif,bisnis',
            'tag' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'preview_color' => 'required|in:green,sky,sand,purple,orange,dark',
            'icon' => 'required|string|max:10',
            'preview_label' => 'required|string|max:50',
            'preview_title' => 'required|string|max:100',
            'is_dark_preview' => 'nullable',
            'long_description' => 'nullable|string|max:1000',
            'price_display' => 'nullable|string|max:50',
            'price_note' => 'nullable|string|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:5120',
        ]);
    }

    private function parseJsonField(?string $text): ?array
    {
        if (empty($text)) return null;
        $decoded = json_decode($text, true);
        return is_array($decoded) ? $decoded : null;
    }

    private function storeOgImage($file): string
    {
        $manager = new ImageManager(new Driver());
        $filename = 'product-seo-' . time() . '-' . uniqid() . '.webp';

        $image = $manager->read($file->getRealPath());
        $image->scaleDown(width: 1200);
        $encoded = $image->toWebp(quality: 82);

        Storage::disk('public')->put('seo/' . $filename, (string) $encoded);

        return $filename;
    }
}
