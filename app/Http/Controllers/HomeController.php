<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function ($q) {
                $q->where('is_active', true);
            }])
            ->orderBy('sort_order')
            ->get();

        // Hanya produk Best Seller pilihan (6 produk terlaris agar tampilan estetik & rapi)
        $bestSellers = Product::where('is_active', true)
            ->where('is_best_seller', true)
            ->with(['category', 'variants'])
            ->orderByDesc('sold_count')
            ->take(6)
            ->get();

        $banners = Banner::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $storeInfo = [
            'name'      => Setting::get('store_name', 'Khadijah Donat & Cake'),
            'phone'     => Setting::get('store_phone', '085360233531'),
            'email'     => Setting::get('store_email', 'halo@khadijahcake.com'),
            'address'   => Setting::get('store_address', 'Lr. SD (Jl. Paya Bili) No. 02, Panggoi, Kec. Muara Dua, Kota Lhokseumawe, Aceh'),
            'instagram' => Setting::get('store_instagram', '@khadijahdonatcake'),
            'tiktok'    => Setting::get('store_tiktok', '@khadijah.donat.n.c'),
        ];

        return view('frontend.home', compact('categories', 'bestSellers', 'banners', 'storeInfo'));
    }
}
