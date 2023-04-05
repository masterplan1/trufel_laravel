<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Image;
use App\Http\Requests\CreateFillingRequest;
use App\Http\Requests\UpdateFillingRequest;
use App\Http\Resources\FillingListResource;
use App\Http\Resources\FillingResource;
use App\Models\Filling;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class FillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        // return FillingListResource::collection(Filling::query()->where('title', 'like', "%vol%")->get());
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        // $search = $request('search', false);
        $type = $request->input('type');
        $sortField = $request->input('sort_field', 'updated_at');
        $sortDirection = $request->input('sort_direction', 'asc');

        $query = Filling::query();
        $query->orderBy($sortField, $sortDirection);
        if($search){
            $query->orWhere('title', 'like', "%$search%");
        }
        if($type){
            $query
                ->join('categories', 'fillings.category_id', '=', 'categories.id')
                ->where('categories.type_id', $type)
                ->select('fillings.*');
        }

        return FillingListResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateFillingRequest $request)
    {
        $data = $request->validated();
        /** @var \Illuminate\Http\UploadedFile $image */
        $image = $data['image'] ?? null;
        if($image){
            $relativePath = Image::saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));
        }
        $filling = Filling::create($data);
        return new FillingResource($filling);
    }

    /**
     * Display the specified resource.
     */
    public function show(Filling $filling)
    {
        return new FillingResource($filling);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFillingRequest $request, Filling $filling)
    {
        $data = $request->validated();
        
        /** @var \Illuminate\Http\UploadedFile $image */
        $image = $data['image'] ?? null;
        if($image){
            $oldImage = $filling->image;

            $relativePath = Image::saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));

            if($oldImage){
                Image::removeImage($oldImage);
            }

        }
        $filling->update($data);
        return new FillingResource($filling);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Filling $filling)
    {
        // $this->removeImage($filling->image);
        Image::removeImage($filling->image);
        $filling->delete();
        return response()->noContent();
    }

    // private function saveImage(UploadedFile $image)
    // {
    //     $path = '/images/' . Str::random() . '-' . time();
    //     $public_path = '/public' . $path;
    //     if(!Storage::exists($public_path)){
    //         Storage::makeDirectory($public_path, 0755, true);
    //     }
    //     if(!Storage::putFileAs($public_path, $image, $image->getClientOriginalName())){
    //         throw new Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
    //     }
    //     return $path . '/' . $image->getClientOriginalName();
    // }

    // private function removeImage($image){
    //     $a = explode('/', $image);
    //     if(is_array($a) && count($a) > 4){
    //         $path = 'public/' . implode('/', [$a[4], $a[5], $a[6]]);
    //         if(Storage::exists($path)){
    //             Storage::deleteDirectory($path);
    //             return true;
    //         }
    //     }
    // }
}
