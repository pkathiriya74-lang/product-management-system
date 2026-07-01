<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
class ProductImages extends Model
{
    protected $fillable=[
        "image",
        "product_id"
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
