<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index()
    {
        return Type::get();
    }
    public function getCategories(Type $type){
        return $type->categories;
    }
    public function getTypeByCategoryId(Category $category)
    {
        $type = $category->type;
        return ['type' => $type->withoutRelations(), 'categories' => $type->categories];
    }
}
