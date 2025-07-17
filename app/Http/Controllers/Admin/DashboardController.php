<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Categories;
use App\Models\Order;
use App\Models\Brand;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'totalProducts' => Product::count(),
            'activeProducts' => Product::where('is_active', 1)->count(), // ✅ perbaikan di sini
            'totalCategories' => Categories::count(),
            'categoriesWithProducts' => Categories::has('products')->count(),
            'totalBrands' => Brand::count(),
            'brandsWithProducts' => Brand::has('products')->count(),
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'processingOrders' => Order::where('status', 'processing')->count(),
            'recentOrders' => Order::latest()->take(3)->get(),
            'recentProducts' => Product::latest()->take(5)->get(),
        ]);
    }
}
