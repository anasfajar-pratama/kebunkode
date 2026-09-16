<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Seo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->get();
        $seo = Seo::make('home');

        return view('home', compact('products', 'seo'));
    }
}
