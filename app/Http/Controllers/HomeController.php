<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with featured products
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get 4 products that are available and in stock
        $featuredProducts = Product::with(['category', 'images', 'colors'])
            ->where('is_available', true)
            ->where('stock', '>', 0)
            ->take(4)
            ->get();

        return view('index', compact('featuredProducts'));
    }
}

