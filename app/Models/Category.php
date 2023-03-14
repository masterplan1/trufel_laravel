<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestemps = false;

    public function type(){
        return $this->belongsTo(Type::class);
    }
}
