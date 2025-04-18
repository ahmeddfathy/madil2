<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with featured products and coupons
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get featured products that are available and in stock
        $featuredProducts = Product::with(['category', 'images', 'colors'])
            ->where('is_available', true)
            ->where('stock', '>', 0)
            ->take(4)
            ->get();

        // Fix for product colors - ensure color_code is available
        foreach ($featuredProducts as $product) {
            // Transform the colors to ensure they have the required properties
            if ($product->colors->isNotEmpty()) {
                $product->colors->transform(function ($color) {
                    // If color_code doesn't exist or is empty, use the color field as fallback
                    if (!isset($color->color_code) || empty($color->color_code)) {
                        $color->color_code = $color->color ?? '#000000';
                    }
                    return $color;
                });
            }
        }

        // Get active coupons ordered by expiration date (closest to expiring first)
        $allCoupons = Coupon::where('is_active', 1)
            ->where('expires_at', '>', now())
            ->orderBy('expires_at', 'asc')
            ->get();

        // Set up pagination for coupons
        $currentPage = $request->get('page', 1);
        $perPage = 2;
        $coupons = $allCoupons->forPage($currentPage, $perPage);
        $totalPages = ceil($allCoupons->count() / $perPage);

        // Get top categories for the sidebar
        $topCategories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(5)
            ->get();

        return view('index', compact(
            'featuredProducts',
            'allCoupons',
            'coupons',
            'currentPage',
            'totalPages',
            'topCategories'
        ));
    }
}

