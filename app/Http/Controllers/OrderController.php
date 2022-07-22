<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::filter()->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function editStatus(Request $request, Order $order)
    {
        $order->update([
            'resi' => $request->resi,
            'status' => $request->status,
        ]);
        return redirect()->route('orders.show', $order)->with('success', 'Status berhasil diubah');
    }
}
