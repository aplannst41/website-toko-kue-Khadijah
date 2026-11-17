<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::whereIn('status', ['paid', 'verified', 'processing', 'ready', 'delivered', 'completed'])->sum('total');
        $totalOrders = Order::count();
        $pendingOrders = Order::whereIn('status', ['pending', 'paid'])->count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();

        $recentOrders = Order::with(['user', 'payment'])->latest()->take(6)->get();
        $lowStockProducts = Product::where('stock', '<=', 5)->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSales', 'totalOrders', 'pendingOrders', 'totalProducts', 'totalCustomers',
            'recentOrders', 'lowStockProducts'
        ));
    }
}
