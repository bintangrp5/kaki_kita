<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DetailOrderController extends Controller
{
    /**
     * Tampilkan semua pesanan (untuk admin).
     */
    public function index()
    {
        $orders = Order::with('customer')->latest()->get();

        return view('dashboard.detail_order.index', compact('orders'));
    }

    /**
     * Tampilkan detail form edit status order.
     */
    public function edit($id)
    {
        $order = Order::with(['customer', 'details.product'])->findOrFail($id);
        return view('dashboard.detail_order.edit', compact('order'));
        // $order = Order::with('customer')->findOrFail($id);
        // return view('dashboard.detail_order.edit', compact('order'));
    }

    /**
     * Update status pesanan.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('detail_order.index')->with('success', 'Status pesanan diperbarui.');
    }
}
