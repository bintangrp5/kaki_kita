<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use Binafy\LaravelCart\Models\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = auth()->guard('customer')->user();
        $cart = Cart::with(['items', 'items.itemable'])->where('user_id', $user->id)->first();

        return view('web.checkout', [ // ubah di sini
            'title' => 'Checkout',
            'cart' => $cart,
        ]);
    }




    public function process(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required',
            'address' => 'required',
            'note'    => 'nullable|string',
        ]);

        $user = auth()->guard('customer')->user();
        $cart = Cart::with(['items', 'items.itemable'])->where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Keranjang kosong.');
        }

        DB::beginTransaction();

        try {
            $total = $cart->items->sum(fn($item) => $item->quantity * $item->itemable->price);

            $order = Order::create([
                'customer_id'  => $user->id,
                'order_date'   => now(),
                'total_amount' => $total,
                'status'       => 'Menunggu Pembayaran',
            ]);

            foreach ($cart->items as $item) {
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->itemable_id,
                    'quantity'   => $item->quantity,
                    'unit_price' => $item->itemable->price,
                    'subtotal'   => $item->quantity * $item->itemable->price,
                ]);
            }

            $cart->items()->delete();
            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
}
