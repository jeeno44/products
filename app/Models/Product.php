<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "categories_id",
        "name_product",
        "price",
        "show",
        "deleted",
    ];

    public function CCategories()
    {
        return $this->belongsTo(Categorie::class,'categories_id','id');
    }
}
