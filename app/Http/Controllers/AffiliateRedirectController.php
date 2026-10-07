<?php

namespace App\Http\Controllers;

use App\Models\ClickLog;
use App\Models\Product;
use Illuminate\Http\Request;

class AffiliateRedirectController extends Controller
{
    public function redirect(Product $product, Request $request)
    {
        if ($product->isAffiliate() && !empty($product->external_url)) {
            // Log click for analytics
            ClickLog::create([
                'product_id' => $product->id,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string)$request->header('User-Agent'), 0, 255),
                'referer' => substr((string)$request->header('referer'), 0, 255),
            ]);

            return redirect()->away($product->external_url);
        }

        return redirect()->route('shop.show', $product->slug);
    }
}
