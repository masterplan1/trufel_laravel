<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image', 'category_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getImageAttribute($value): ?string
    {
        return $value ? URL::to(Storage::url($value)) : null;
    }
}
