<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images'])->where('is_active', true);

        // Filter by Category
        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search query
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();
        $featuredProducts = Product::with(['category', 'images'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->take(6)
            ->get();

        return view('tienda.index', compact('products', 'categories', 'featuredProducts'));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'images'])->where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        $relatedProducts = Product::with(['category', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('tienda.show', compact('product', 'relatedProducts'));
    }

    /**
     * Redirige un enlace corto de producto (/p/{identifier}) a la página completa del producto.
     */
    public function shortRedirect($identifier)
    {
        $query = Product::where('is_active', true);

        // 1. Buscar por short_code personalizado
        $product = (clone $query)->where('short_code', $identifier)->first();

        // 2. Si no existe y el identificador es numérico, buscar por ID
        if (!$product && is_numeric($identifier)) {
            $product = (clone $query)->where('id', $identifier)->first();
        }

        // 3. Fallback: buscar por slug
        if (!$product) {
            $product = (clone $query)->where('slug', $identifier)->first();
        }

        if (!$product) {
            return redirect()->route('shop.index')->with('error', 'El producto solicitado no existe o ya no está disponible.');
        }

        $queryParams = request()->query();
        $targetUrl = route('shop.show', $product->slug);
        if (!empty($queryParams)) {
            $targetUrl .= '?' . http_build_query($queryParams);
        }

        return redirect()->to($targetUrl, 302);
    }
}
