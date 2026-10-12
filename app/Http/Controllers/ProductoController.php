<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images']);

        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status == 'active');
        }

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $products = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('productos.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('productos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,svg,jfif,avif,bmp|max:20480',
            'image_urls' => 'nullable|string',
        ], [
            'images.*.file' => 'Uno de los archivos seleccionados no es un archivo válido.',
            'images.*.mimes' => 'Las imágenes deben estar en formato JPG, PNG, WEBP, GIF, JFIF o AVIF.',
            'images.*.max' => 'Cada imagen no debe superar los 20MB de tamaño.',
            'title.required' => 'El título del producto es obligatorio.',
            'category_id.required' => 'Debes seleccionar una categoría.',
            'price.required' => 'El precio de venta es obligatorio.',
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $slug,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'type' => 'direct',
            'external_url' => null,
            'platform_name' => null,
            'stock' => $request->stock ?? 0,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
        ]);

        // Upload local images
        if ($request->hasFile('images')) {
            $destination = public_path('uploads/products');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $first = true;
            foreach ($request->file('images') as $index => $file) {
                if ($file && $file->isValid()) {
                    $ext = $file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg';
                    $filename = time() . '_' . uniqid() . '.' . strtolower($ext);
                    $file->move($destination, $filename);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'uploads/products/' . $filename,
                        'is_primary' => $first,
                        'sort_order' => $index + 1,
                    ]);
                    $first = false;
                }
            }
        }

        // Add image URLs
        if ($request->filled('image_urls')) {
            $urls = array_filter(array_map('trim', explode("\n", $request->image_urls)));
            $isFirst = !$product->images()->exists();
            foreach ($urls as $i => $url) {
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $url,
                        'is_primary' => $isFirst,
                        'sort_order' => 10 + $i,
                    ]);
                    $isFirst = false;
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('images');
        return view('productos.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,svg,jfif,avif,bmp|max:20480',
            'image_urls' => 'nullable|string',
        ], [
            'images.*.file' => 'Uno de los archivos seleccionados no es un archivo válido.',
            'images.*.mimes' => 'Las imágenes deben estar en formato JPG, PNG, WEBP, GIF, JFIF o AVIF.',
            'images.*.max' => 'Cada imagen no debe superar los 20MB de tamaño.',
            'title.required' => 'El título del producto es obligatorio.',
            'category_id.required' => 'Debes seleccionar una categoría.',
            'price.required' => 'El precio de venta es obligatorio.',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'type' => 'direct',
            'external_url' => null,
            'platform_name' => null,
            'stock' => $request->stock ?? 0,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ]);

        if ($request->hasFile('images')) {
            $destination = public_path('uploads/products');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $hasImages = $product->images()->exists();
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $ext = $file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg';
                    $filename = time() . '_' . uniqid() . '.' . strtolower($ext);
                    $file->move($destination, $filename);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'uploads/products/' . $filename,
                        'is_primary' => !$hasImages,
                        'sort_order' => 20,
                    ]);
                    $hasImages = true;
                }
            }
        }

        if ($request->filled('image_urls')) {
            $urls = array_filter(array_map('trim', explode("\n", $request->image_urls)));
            foreach ($urls as $url) {
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $url,
                        'is_primary' => !$product->images()->exists(),
                        'sort_order' => 30,
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
        $productId = $image->product_id;
        $image->delete();
        return redirect()->route('admin.products.edit', $productId)->with('success', 'Imagen eliminada.');
    }
}
