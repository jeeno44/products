<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use App\Models\Product;

class Cat_prod extends Model
{
    use HasFactory;

    protected $fillable = [
        "categories_id",
        "product_id",
        "deleted"
    ];


    public function Products ()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }


    public function Categories()
    {
        return $this->belongsTo(Categorie::class,'categories_id','id');
    }

}
