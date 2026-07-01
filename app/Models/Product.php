<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\ProductImages;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'price',
        'stock',
        'category_id',
        'image',
        'sku',
        'status'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function productImages(){
        return $this->hasMany(ProductImages::class);
    }
}
