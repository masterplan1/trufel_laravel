<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    public $timestemps = false;

    public function categories(){
        return $this->hasMany(Category::class);
    }
    public function fillings($limit = 6){
        return $this->hasManyThrough(Filling::class, Category::class)->limit($limit);
    }
    // public function fillings($limit = 6, $offset = 0){
    //     return $this->hasManyThrough(Filling::class, Category::class)->offset($offset)->limit($limit);
    // }
    public static function getAll(){
        return self::get();
    }
    public function getAdditionalFillings($categoryId = 0, $offset = null, $limit = 6, ){
        $query = Filling::query()->select(['f.*'])->from('fillings as f')
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
        return $query->limit($limit)->get();
    }
}
