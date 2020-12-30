<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use App\Models\Cat_prod;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name_product",
        "price",
        "show",
        "deleted",
    ];

    public function Categories ()
    {
        return $this->hasMany(Cat_prod::class,'product_id','id');
    }

    /*public function CCategories()
    {
        return $this->belongsTo(Categorie::class,'categories_id','id');
    }*/
}
