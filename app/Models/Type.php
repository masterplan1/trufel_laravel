<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'weight_quantity', 'is_candybar', 'is_candybar_group', 'image'];

    public function getImageAttribute($value): ?string
    {
        return $value ? \Illuminate\Support\Facades\URL::to(\Illuminate\Support\Facades\Storage::url($value)) : null;
    }

    public function previewImage(): ?string
    {
        if ($this->getRawOriginal('image')) {
            return $this->image;
        }
        // fallback: перше зображення першої категорії
        $filling = $this->categories()->with('fillings')->first()?->fillings()->first();
        return $filling?->image;
    }

    public function categories($limit = null){
        return $this->hasMany(Category::class)->limit($limit);
    }
    public function fillings($limit = 6){
        return $this->hasManyThrough(Filling::class, Category::class)->latest('fillings.id')->limit($limit);
    }
    public function products($limit = 6){
        return $this->hasManyThrough(Product::class, Category::class)->latest('products.id')->limit($limit);
    }
    // public function fillings($limit = 6, $offset = 0){
    //     return $this->hasManyThrough(Filling::class, Category::class)->offset($offset)->limit($limit);
    // }
    public static function getAll(){
        // Меню: звичайні типи (is_candybar=0) + агрегатор кендібару (is_candybar_group=1)
        // Підтипи кендібару (is_candybar=1, is_candybar_group=0) в меню не показуються
        return self::where('is_candybar', false)->get();
    }
    public function getAdditionalFillings($categoryId = 0, $offset = null, $limit = 6){
        $query = Filling::query()->select(['f.*', 't.id as type_id', 
            't.weight_quantity as type_weight_quantity', 't.is_candybar as type_is_candybar', 
            't.name as type_name'])
            ->from('fillings as f')
            ->join('categories as c', 'f.category_id', '=', 'c.id')
            ->join('types as t', 'c.type_id', '=', 't.id');
        if($categoryId != 0){
            $query->where('f.category_id', $categoryId);
        } else {
            $query->where('t.id', $this->id);
        }
        if($offset){
            $query->offset($offset);
        }
        return $query->orderBy('f.id', 'desc')->limit($limit)->get();
    }
}
