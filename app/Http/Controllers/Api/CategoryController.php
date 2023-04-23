<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        
        $type = $request->input('type');
        $sortField = $request->input('sort_field', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');

        $query = Category::query();
        $query->orderBy($sortField, $sortDirection);
        if($search){
            $query->orWhere('name', 'like', "%$search%");
        }
        if($type){
            $query->where('type_id', $type);
        }
        return CategoryResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $filling = Category::create($request->validated());
        return new CategoryResource($filling);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if(count($category->fillings) === 0){
            $category->delete();
            return response()->noContent();
        } else {
            throw new Exception('Категорія містить начинки!');
        }
        
    }
}
