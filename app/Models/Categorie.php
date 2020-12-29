<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Cat_prod;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = ['name_categories'];

    public function Products ()
    {
        return $this->hasMany(Cat_prod::class,'categories_id','id');
    }

    /*public function PProducts ()
    {
        return $this->hasMany(Product::class,'categories_id','id');
    }*/

}
