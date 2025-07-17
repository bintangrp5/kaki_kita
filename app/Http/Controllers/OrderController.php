<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->guard('customer')->user();

        if (!$user) {
            return redirect()->route('customer.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $orders = Order::where('customer_id', $user->id)->latest()->get();
        return view('web.order', compact('orders'));
    }

    // public function index()
    // {
    //     $user = auth()->guard('customer')->user();
    //     $orders = Order::where('customer_id', $user->id)->latest()->get();

    //     return view('web.order', compact('orders'));
    // }

    public function show($id)
    {
        $user = auth()->guard('customer')->user();
        $order = Order::with('details.product') // eager load produk
            ->where('customer_id', $user->id)
            ->findOrFail($id);

        return view('web.order_detail', compact('order'));
    }

    // public function show($id)
    // {
    //     $user = auth()->guard('customer')->user();
    //     $order = Order::where('customer_id', $user->id)->findOrFail($id);

    //     return view('web.order_detail', compact('order'));
    // }
}
