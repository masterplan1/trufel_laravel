<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Filling;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'orders_total' => Order::count(),
            'orders_new' => Order::where('status', 'new')->count(),
            'orders_active' => Order::where('status', 'active')->count(),
            'orders_completed' => Order::where('status', 'completed')->count(),
            'revenue_total' => Order::where('status', 'completed')->sum('total_price'),
            'fillings_count' => Filling::count(),
            'products_count' => Product::count(),
            'comments_count' => Comment::count(),
            'recent_orders' => Order::with('orderDetail')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(fn($o) => [
                    'id' => $o->id,
                    'status' => $o->status,
                    'total_price' => $o->total_price,
                    'customer_name' => $o->orderDetail?->customer_name,
                    'order_date' => $o->orderDetail?->order_date,
                    'created_at' => $o->created_at->format('d.m.Y H:i'),
                ]),
        ]);
    }
}
