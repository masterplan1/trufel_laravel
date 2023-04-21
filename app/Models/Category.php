<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'type_id'];
    public function type(){
        return $this->belongsTo(Type::class);
    }
    public function fillings(){
        return $this->hasMany(Filling::class);
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
}
