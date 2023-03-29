<?php

namespace App\Http\Controllers;

use App\Http\Resources\CandybarResource;
use App\Models\Category;
use App\Models\Filling;
use App\Models\Type;
use Illuminate\Http\Request;

class FillingController extends Controller
{
    public const ITEMS_PER_REQUEST = 6;
    public function index(Type $type)
    {
        
        $type = $type->withoutRelations();
        if($type->is_candybar){
            $categories = $type->categories(6)->get();
            $total_item_count  = $type->categories()->count();
            return view('filling.candybar', compact('categories', 'type', 'total_item_count'));
        }
        $fillings = $type->fillings;
        $categories = $type->categories;
        $total_item_count = $type->fillings(null)->count();
        return view('filling', compact('fillings', 'categories', 'type', 'total_item_count'));
    }

    public function addFillings(Request $request, Type $type)
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
            'fillings' => $type->getAdditionalFillings($categoryId, $offset, $limit), 
            'items_count' => $itemsCount
        ];
    }

    public function addCategories(Request $request, Type $type){
        $offset = $request->post('offset', 0);
        $limit = self::ITEMS_PER_REQUEST;
        return [
            'fillings' => CandybarResource::collection(Category::where('type_id', $type->id)->with('fillings')->offset($offset)->limit($limit)->get()), 
            'items_count' => 0
        ];
    }
}
