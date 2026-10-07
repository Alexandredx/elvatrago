<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('shop.cart', compact('cart', 'subtotal'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $availableStock = ($product->type === 'affiliate' || $product->stock <= 0) ? 999 : $product->stock;

        if ($availableStock < $quantity) {
            return back()->with('error', 'Lo sentimos, solo hay ' . $availableStock . ' unidades disponibles en stock.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;
            if ($newQuantity > $availableStock) {
                return back()->with('error', 'No puedes añadir más unidades de las disponibles en stock.');
            }
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->effective_price,
                'quantity' => $quantity,
                'image' => $product->primary_image_url,
                'slug' => $product->slug,
                'stock' => $availableStock,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', '¡Producto añadido al carrito con éxito!');
    }

    public function update(Request $request, $id)
    {
        $quantity = (int) $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $product = Product::find($id);
            if ($product && $quantity > $product->stock) {
                return back()->with('error', 'La cantidad supera el stock disponible (' . $product->stock . ').');
            }

            if ($quantity <= 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['quantity'] = $quantity;
            }

            session()->put('cart', $cart);
        }

        return back()->with('success', 'Carrito actualizado.');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'El carrito ha sido vaciado.');
    }
}
