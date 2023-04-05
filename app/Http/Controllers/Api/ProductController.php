<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Image;
use App\Http\Requests\CreateProductRequest;
use App\Http\Resources\ProductListResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $perPage = $request->input('per_page', 10);
        $type = $request->input('type');
        $sortField = $request->input('sort_field', 'updated_at');
        $sortDirection = $request->input('sort_direction', 'asc');

        $query = Product::query();
        $query->orderBy($sortField, $sortDirection);

        if($type){
            $query
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where('categories.type_id', $type)
                ->select('products.*');
        }

        return ProductListResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $data = $request->validated();
        /** @var \Illuminate\Http\UploadedFile $image */
        $image = $data['image'] ?? null;
        if($image){
            $relativePath = Image::saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));
        }
        $product = Product::create($data);
        return new ProductListResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductListResource($product);
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Image::removeImage($product->image);
        $product->delete();
        return response()->noContent();
    }
}
