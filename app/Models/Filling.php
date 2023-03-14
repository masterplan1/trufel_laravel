<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filling extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'description', 'image', 'min_weight', 'min_quantity', 'category_id', 'unit_price'];
    
}
