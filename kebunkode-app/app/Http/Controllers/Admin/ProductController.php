<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $id = $product?->id;
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
        ]);
    }

    private function parseJsonField(?string $text): ?array
    {
        if (empty($text)) return null;
        $decoded = json_decode($text, true);
        return is_array($decoded) ? $decoded : null;
    }
}
