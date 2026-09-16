<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SeoController extends Controller
{
    public function index()
    {
        $global = SeoSetting::firstOrCreate(
            ['page_key' => 'global'],
            ['page_label' => 'Pengaturan Global']
        );
        $home = SeoSetting::firstOrCreate(
            ['page_key' => 'home'],
            ['page_label' => 'Halaman Beranda']
        );

        return view('admin.seo.index', compact('global', 'home'));
    }

    public function update(Request $request, string $pageKey)
    {
        $setting = SeoSetting::firstOrCreate(['page_key' => $pageKey]);

        $rules = [
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'robots' => 'nullable|string|max:100',
            'canonical_url' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_type' => 'nullable|string|max:50',
            'og_image' => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:5120',
            'twitter_card' => 'nullable|string|max:50',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
            'twitter_image' => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:5120',
            'twitter_site' => 'nullable|string|max:100',
            'structured_data' => 'nullable|string',
            'google_analytics_id' => 'nullable|string|max:100',
            'google_site_verification' => 'nullable|string|max:255',
            'google_tag_manager_id' => 'nullable|string|max:100',
            'robots_txt' => 'nullable|string',
            'sitemap_frequency' => 'nullable|string|max:20',
            'sitemap_priority' => 'nullable|numeric|min:0|max:1',
        ];

        $data = $request->validate($rules);

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->storeImage($request->file('og_image'), 'seo');
        }
        if ($request->hasFile('twitter_image')) {
            $data['twitter_image'] = $this->storeImage($request->file('twitter_image'), 'seo');
        }

        if (!empty($data['structured_data'])) {
            json_decode($data['structured_data']);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withInput()->withErrors([
                    'structured_data' => 'Format JSON tidak valid: ' . json_last_error_msg(),
                ]);
            }
        }

        $setting->update($data);

        return back()->with('success', 'Pengaturan SEO berhasil disimpan.');
    }

    public function removeImage(Request $request, string $pageKey)
    {
        $setting = SeoSetting::where('page_key', $pageKey)->firstOrFail();
        $field = $request->input('field');

        if (in_array($field, ['og_image', 'twitter_image']) && $setting->{$field}) {
            Storage::disk('public')->delete('seo/' . $setting->{$field});
            $setting->update([$field => null]);
        }

        return back()->with('success', 'Gambar berhasil dihapus.');
    }

    private function storeImage($file, string $folder): string
    {
        $manager = new ImageManager(new Driver());
        $filename = 'seo-' . time() . '-' . uniqid() . '.webp';

        $image = $manager->read($file->getRealPath());
        $image->scaleDown(width: 1200);
        $encoded = $image->toWebp(quality: 82);

        Storage::disk('public')->put($folder . '/' . $filename, (string) $encoded);

        return $filename;
    }
}
