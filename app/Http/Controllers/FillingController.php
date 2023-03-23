<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class FillingController extends Controller
{
    public function index(Type $type)
    {
        $fillings = $type->fillings;
        $categories = $type->categories;
        $type = $type->withoutRelations();

        // echo '<pre>';
        // print_r($categories[3]->fillings[0]);
        // exit;
        if($type->is_candybar){
            return view('candybar', compact('fillings', 'categories', 'type'));
        }
        return view('filling', compact('fillings', 'categories', 'type'));
    }
}
