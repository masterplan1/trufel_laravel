<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $status = $request->input('status');
        $sortField = $request->input('sort_field', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $query = Order::query()
            ->with(['orderDetail', 'orderItems.filling'])
            ->orderBy($sortField, $sortDirection);

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->paginate($perPage);

        return response()->json([
            'data' => $orders->map(fn($order) => [
                'id' => $order->id,
                'status' => $order->status,
                'total_price' => $order->total_price,
                'customer_name' => $order->orderDetail?->customer_name,
                'customer_phone' => $order->orderDetail?->customer_phone,
                'order_date' => $order->orderDetail?->order_date,
                'comment' => $order->orderDetail?->comment,
                'items_count' => $order->orderItems->count(),
                'items' => $order->orderItems->map(fn($item) => [
                    'id' => $item->id,
                    'filling_title' => $item->filling?->title,
                    'unit_price' => $item->unit_price,
                    'quantity' => $item->quantity,
                    'weight' => $item->weight,
                ]),
                'created_at' => $order->created_at->format('d.m.Y H:i'),
            ]),
            'meta' => [
                'total' => $orders->total(),
                'per_page' => $orders->perPage(),
                'from' => $orders->firstItem(),
                'to' => $orders->lastItem(),
                'links' => $orders->linkCollection()->toArray(),
            ],
        ]);
    }

    public function destroy(Order $order)
    {
        $order->delete(); // soft delete — запис залишається в БД
        return response()->noContent();
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,active,completed',
        ]);
        $order->update($validated);
        return response()->json(['status' => $order->status]);
    }
}
