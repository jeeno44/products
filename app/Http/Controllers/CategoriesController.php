<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Product;
use App\Models\Cat_prod;

class CategoriesController extends Controller
{
    public function getAll ($id = null)
    {
        if (!$id){

            $allCategories = Categorie::where(["deleted" => 0])->get();

            return $allCategories->toJson();
        }
        else{

            $categorie = Categorie::where(["id" => $id])->where(["deleted" => 0])->get();

            if (count($categorie) == 0){
                return "Категория не найдена";
            }
            else{
                return $categorie[0]->toJson();
            }
        }
    }

    public function createCategorie ($name)
    {
        $find = Categorie::where(["name_categories" => $name])->get();

        if (count($find) == 0){
            Categorie::create(['name_categories' => $name]);

            return "Категория добавлена";
        }
        else{
            return "Категория уже сужествует";
        }
    }

    public function updateCategorie ($id,$name)
    {
        $categorie = Categorie::where(["id" => $id])->get();

        if (count($categorie) == 0){
            return "Категория не найдена";
        }
        else{
            $categorie[0]->name_categories = $name;
            $categorie[0]->save();
            return "Категория обновлена";
        }
    }

    public function deleteCategorie ($id)
    {
        $categorie = Categorie::where(["id" => $id])->where(["deleted" => 0])->get();

        // проверка существования категории
        if (count($categorie) == 0){
            return "Категория не найдена";
        }
        else{

            $del_id = $categorie[0]->Products()->where(["deleted" => 0])->get();

            if (count($del_id) > 0){

                $products = [];

                foreach ($del_id as $prods) {
                    $products[] = $prods->id;
                }

                $products = implode(",",$products);
                return "У этой категории есть товары с идентификаторами $products , сначала удалите товары";
            }
            else{

                $categorie = Categorie::where(["id" => $id])->first();
                $categorie->deleted = 1;
                $categorie->save();

                return "Категория удалена";
            }

        }
    }
}
