<?php

namespace App\Http\Controllers;

use App\Models\Filling;
use App\Models\Type;
use Illuminate\Http\Request;

class FillingController extends Controller
{
    public const FILLINFS_PER_REQUEST = 6;
    public function index(Type $type)
    {
        $fillings = $type->fillings;
        $categories = $type->categories;
        $type = $type->withoutRelations();

        if($type->is_candybar){
            return view('candybar', compact('fillings', 'categories', 'type'));
        }
        return view('filling', compact('fillings', 'categories', 'type'));
    }

    public function addFillings(Request $request, Type $type)
    {
        $offset = $request->post('offset', 0);
        $categoryId = $request->post('category_id', 0);
        // return $categoryId;
        $limit = self::FILLINFS_PER_REQUEST;
        return $type->getAdditionalFillings($categoryId, $offset, $limit);
    }
}
