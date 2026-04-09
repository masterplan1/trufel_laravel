<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public const ITEMS_PER_REQUEST = 6;

    public function index(Type $type)
    {
        $products = $type->products;
        $total_item_count = Product::where('type_id', $type->id)->count();
        return view('product.index', compact('products', 'type', 'total_item_count'));
    }

    public function addProducts(Request $request, Type $type)
    {
        $offset = $request->post('offset', 0);
        $limit = self::ITEMS_PER_REQUEST;
        $products = Product::where('type_id', $type->id)
            ->latest('id')
            ->offset($offset)
            ->limit($limit)
            ->get()
            ->map(fn($p) => ['id' => $p->id, 'image' => $p->image]);
        return [
            'products' => $products,
            'items_count' => Product::where('type_id', $type->id)->count(),
        ];
    }
}
