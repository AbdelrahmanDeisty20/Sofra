<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['client', 'restaurant']);

        if ($request->has('state')) {
            $query->where('state', $request->state);
        }

        $orders = $query->latest()->paginate(15);
        return OrderResource::collection($orders);
    }

    public function show($id)
    {
        $order = Order::with(['client', 'restaurant', 'products'])->findOrFail($id);
        return new OrderResource($order);
    }

    public function updateState(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'state' => 'required|in:pending,accepted,rejected,delivered,declined',
        ]);

        $order->state = $request->state;
        $order->save();

        return response()->json([
            'message' => 'Order state updated successfully',
            'state' => $order->state
        ]);
    }

    public function commissions()
    {
        $totalCommissions = Order::where('state', 'delivered')->sum('commission');
        $totalPayments = \App\Models\Payment::sum('amount');

        return response()->json([
            'total_commissions' => $totalCommissions,
            'total_payments' => $totalPayments,
            'remaining_commissions' => $totalCommissions - $totalPayments,
        ]);
    }
}
