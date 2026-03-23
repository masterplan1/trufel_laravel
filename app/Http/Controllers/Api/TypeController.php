<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeRequest;
use App\Http\Resources\TypeResource;
use App\Models\Category;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $sortField = $request->input('sort_field', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');

        $query = Type::query()->orderBy($sortField, $sortDirection);

        if ($search) {
            $query->where('name', 'like', "%$search%");
        }

        return TypeResource::collection($query->paginate($perPage));
    }

    public function store(TypeRequest $request)
    {
        $type = Type::create($request->validated());
        return new TypeResource($type);
    }

    public function show(Type $type)
    {
        return new TypeResource($type);
    }

    public function update(TypeRequest $request, Type $type)
    {
        $type->update($request->validated());
        return new TypeResource($type);
    }

    public function destroy(Type $type)
    {
        if (Category::where('type_id', $type->id)->count() === 0) {
            $type->delete();
            return response()->noContent();
        } else {
            throw new Exception('Тип містить категорії!');
        }
    }

    public function getCategories(Type $type)
    {
        return $type->categories;
    }

    public function getTypeByCategoryId(Category $category)
    {
        $type = $category->type;
        return ['type' => $type->withoutRelations(), 'categories' => $type->categories];
    }

    public function all()
    {
        return Type::all();
    }
}
