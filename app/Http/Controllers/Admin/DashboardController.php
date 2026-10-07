<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClickLog;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $directProducts = Product::where('type', 'direct')->count();
        $affiliateProducts = Product::where('type', 'affiliate')->count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalClicks = ClickLog::count();

        $recentClickLogs = ClickLog::with('product')->latest()->take(8)->get();
        $recentOrders = Order::latest()->take(5)->get();

        // Top clicked affiliate products
        $topAffiliates = Product::where('type', 'affiliate')
            ->withCount('clickLogs')
            ->orderBy('click_logs_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'directProducts',
            'affiliateProducts',
            'totalOrders',
            'totalRevenue',
            'totalClicks',
            'recentClickLogs',
            'recentOrders',
            'topAffiliates'
        ));
    }
}
