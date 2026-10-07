<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images'])->withCount('clickLogs');

        if ($request->has('type') && in_array($request->type, ['direct', 'affiliate'])) {
            $query->where('type', $request->type);
        }

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $products = $query->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'type' => 'required|in:direct,affiliate',
            'external_url' => 'nullable|required_if:type,affiliate|string',
            'platform_name' => 'nullable|string',
            'stock' => 'required_if:type,direct|integer|min:0',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'image_urls' => 'nullable|string',
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $product = Product::create([
            'title' => $request->title,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'type' => $request->type,
            'external_url' => $request->type === 'affiliate' ? $request->external_url : null,
            'platform_name' => $request->type === 'affiliate' ? ($request->platform_name ?? 'affiliate') : null,
            'stock' => $request->type === 'direct' ? ($request->stock ?? 0) : 0,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active') ? true : true,
        ]);

        // Process File Uploads
        if ($request->hasFile('images')) {
            $isPrimary = true;
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $isPrimary,
                    'sort_order' => $index + 1,
                ]);
                $isPrimary = false;
            }
        }

        // Process Image URLs (if provided)
        if ($request->filled('image_urls')) {
            $urls = array_map('trim', explode("\n", $request->image_urls));
            $isPrimary = $product->images()->count() === 0;
            foreach ($urls as $index => $url) {
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $url,
                        'is_primary' => $isPrimary,
                        'sort_order' => $index + 10,
                    ]);
                    $isPrimary = false;
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'type' => 'required|in:direct,affiliate',
            'external_url' => 'nullable|required_if:type,affiliate|string',
            'platform_name' => 'nullable|string',
            'stock' => 'required_if:type,direct|integer|min:0',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'image_urls' => 'nullable|string',
        ]);

        $product->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'type' => $request->type,
            'external_url' => $request->type === 'affiliate' ? $request->external_url : null,
            'platform_name' => $request->type === 'affiliate' ? ($request->platform_name ?? 'affiliate') : null,
            'stock' => $request->type === 'direct' ? ($request->stock ?? 0) : 0,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active'),
        ]);

        // Process File Uploads
        if ($request->hasFile('images')) {
            $currentMaxSort = $product->images()->max('sort_order') ?? 0;
            $hasPrimary = $product->images()->where('is_primary', true)->exists();
            
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => !$hasPrimary && $index === 0,
                    'sort_order' => $currentMaxSort + $index + 1,
                ]);
            }
        }

        // Process Additional Image URLs
        if ($request->filled('image_urls')) {
            $urls = array_map('trim', explode("\n", $request->image_urls));
            $currentMaxSort = $product->images()->max('sort_order') ?? 0;
            $hasPrimary = $product->images()->where('is_primary', true)->exists();

            foreach ($urls as $index => $url) {
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $url,
                        'is_primary' => !$hasPrimary && $index === 0,
                        'sort_order' => $currentMaxSort + $index + 1,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado.');
    }

    public function deleteImage(ProductImage $image)
    {
        $image->delete();
        return back()->with('success', 'Imagen eliminada.');
    }
}
