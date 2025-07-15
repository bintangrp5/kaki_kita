<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Binafy\LaravelCart\Models\Cart;
use Binafy\LaravelCart\Models\CartItem;

class CartController extends Controller
{
    private function getCart()
    {
        return Cart::with(['items', 'items.itemable'])
            ->firstOrCreate(['user_id' => auth()->guard('customer')->id()]);
    }

    public function index()
    {
        $cart = $this->getCart();
        return view('cart', [
            'title' => 'Keranjang Belanja',
            'cart' => $cart
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = $this->getCart();
        $cartItem = new CartItem([
            'itemable_id' => $product->id,
            'itemable_type' => Product::class,
            'quantity' => $request->quantity,
        ]);

        $cart->items()->save($cartItem);

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function remove($id)
    {
        $cart = $this->getCart();
        $item = $cart->items()->where('itemable_id', $id)->first();
        if ($item) $item->delete();

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
    }

    public function update($id, Request $request)
    {
        $cart = $this->getCart();
        $item = $cart->items()->where('itemable_id', $id)->first();

        if ($item) {
            if ($request->action === 'increase') $item->quantity++;
            elseif ($request->action === 'decrease' && $item->quantity > 1) $item->quantity--;
            $item->save();
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui.');
    }
}
