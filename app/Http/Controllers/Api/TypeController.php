<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Image;
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
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = Image::saveImage($request->file('image'));
        }
        $type = Type::create($data);
        return new TypeResource($type);
    }

    public function show(Type $type)
    {
        return new TypeResource($type);
    }

    public function update(TypeRequest $request, Type $type)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $oldImage = $type->getRawOriginal('image');
            $data['image'] = Image::saveImage($request->file('image'));
            if ($oldImage) {
                Image::removeImage($oldImage);
            }
        }
        $type->update($data);
        return new TypeResource($type);
    }

    public function destroy(Type $type)
    {
        if (Category::where('type_id', $type->id)->count() === 0) {
            $oldImage = $type->getRawOriginal('image');
            $type->delete();
            if ($oldImage) {
                Image::removeImage($oldImage);
            }
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
