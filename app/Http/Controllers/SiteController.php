<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Filling;
use App\Models\Type;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $featuredFillings = Filling::with('type')
            ->whereNotNull('type_id')
            ->whereHas('type', fn($q) => $q->where('is_candybar', false))
            ->latest()
            ->limit(6)
            ->get()
            ->map(fn($filling) => [
                'id'                   => $filling->id,
                'image'                => $filling->image,
                'title'                => $filling->title,
                'unit_price'           => $filling->unit_price,
                'min_weight'           => $filling->min_weight,
                'min_quantity'         => $filling->min_quantity,
                'type_id'              => $filling->type->id,
                'type_name'            => $filling->type->name,
                'type_weight_quantity' => $filling->type->weight_quantity,
                'type_is_candybar'     => $filling->type->is_candybar,
                'description'          => $filling->description,
                'type_route'           => route('filling', $filling->type),
            ]);

        $recentComments = Comment::latest()->limit(3)->get();
        $menuTypes = Type::where('is_candybar', false)->get();

        return view('welcome', compact('featuredFillings', 'recentComments', 'menuTypes'));
    }

    public function contacts()
    {
        return view('contacts');
    }
}
