<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'required|image|mimes:jpeg,jpg,png,webp,gif|max:5120',
        ]);

        $maxOrder = $product->images()->max('sort_order') ?? 0;
        $manager = new ImageManager(new Driver());

        foreach ($request->file('images') as $file) {
            $maxOrder++;
            $filename = $this->processAndSaveImage($manager, $file, $maxOrder);

            $product->images()->create([
                'filename' => $filename,
                'alt_text' => $product->name,
                'sort_order' => $maxOrder,
            ]);
        }

        return back()->with('success', 'Gambar berhasil diupload.');
    }

    public function destroy(ProductImage $image)
    {
        Storage::disk('public')->delete('products/' . $image->filename);
        Storage::disk('public')->delete('products/thumbnails/' . $image->filename);

        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }

    public function reorder(Request $request, Product $product)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:product_images,id',
        ]);

        foreach ($request->input('order') as $index => $imageId) {
            ProductImage::where('id', $imageId)
                ->where('product_id', $product->id)
                ->update(['sort_order' => $index + 1]);
        }

        return back()->with('success', 'Urutan gambar berhasil diubah.');
    }

    private function processAndSaveImage(ImageManager $manager, $file, int $order): string
    {
        $filename = 'product-' . time() . '-' . $order . '.webp';

        $image = $manager->read($file->getRealPath());
        $image->scaleDown(width: 1200);
        $encoded = $image->toWebp(quality: 80);
        Storage::disk('public')->put('products/' . $filename, (string) $encoded);

        $thumbnail = $manager->read($file->getRealPath());
        $thumbnail->scaleDown(width: 400);
        $thumbEncoded = $thumbnail->toWebp(quality: 70);
        Storage::disk('public')->put('products/thumbnails/' . $filename, (string) $thumbEncoded);

        return $filename;
    }
}
