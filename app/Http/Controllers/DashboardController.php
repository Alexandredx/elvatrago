<?php

namespace App\Http\Controllers;

use App\Models\ClickLog;
use App\Models\Order;
use App\Models\Product;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $lowStockProducts = Product::where('stock', '<=', 5)->count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $pendingReturns = ReturnRequest::where('status', 'pending')->count();

        $recentOrders = Order::latest()->take(6)->get();
        $latestProducts = Product::with('category')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'totalOrders',
            'totalRevenue',
            'pendingReturns',
            'recentOrders',
            'latestProducts'
        ));
    }
}

