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
        return view('filling', compact('fillings', 'categories', 'type'));
    }
}
