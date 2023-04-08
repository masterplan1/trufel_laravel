<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public const ITEMS_PER_REQUEST = 6;
    public function index(Type $type)
    {
        
        // $type = $type->withoutRelations();
        $products = $type->products;
        $categories = $type->categories;
        $total_item_count = $type->fillings(null)->count();
        return view('product.index', compact('products', 'categories', 'type', 'total_item_count'));
    }

    public function addProducts(Request $request, Type $type)
    {
        $offset = $request->post('offset', 0);
        $categoryId = $request->post('category_id', 0);
        // return $categoryId;
        $limit = self::ITEMS_PER_REQUEST;
        if($categoryId === 0){
            $itemsCount = $type->fillings(null)->count();
        } else {
            $itemsCount = Category::find($categoryId)->fillings()->count();
        }
        return [
            'products' => $type->getAdditionalFillings($categoryId, $offset, $limit), 
            'items_count' => $itemsCount
        ];
    }
}
