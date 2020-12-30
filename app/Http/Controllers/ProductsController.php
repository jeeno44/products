<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Categorie;
use App\Models\Cat_prod;

class ProductsController extends Controller
{
    public function getAll ($id = null)
    {
        if (!$id){

            $allProducts = Product::where(["deleted" => 0])->get();

            return $allProducts->toJson();
        }
        else{

            $product = Product::where(["id" => $id])->where(["deleted" => 0])->get();

            if (count($product) == 0){
                return "Товар не найден";
            }
            else{
                return $product[0]->toJson();
            }
        }
    }

    public function getByName ($name)
    {
        $products = Product::where("name_product","like","%".$name."%")->get();

        if (count($products) > 0){
            return $products->toJson();
        }
        else{
            return "Товары не найдены";
        }
    }

    public function getByCategory ($category)
    {
        $category = Categorie::where("name_categories",'like',$category)->get();

        if (count($category) > 0){

            $products = [];

            foreach ($category[0]->Products as $prods) {
                $products[] = $prods->Products;
            }

            if (count($products) > 0){
                return $products;
            }
            else{
                return "У этой категории нет продуктов";
            }
        }
        else{
            return "Категория не найдена";
        }
    }

    public function getByPrice ($price)
    {
        $price = explode("-",$price);

        $start  = ((int)$price[0] != 0) ? intval($price[0]) : false ;
        $stop   = ((int)$price[1] != 0) ? intval($price[1]) : false ;

        if (!$start or !$stop) {
            return "Вы ввели неправильное значение";
        }
        else{

            if ($start >= $stop){
                return "Вы ввели неправильное значение";
            }
            else{

                $products = Product::whereBetween("price",[$start,$stop])->get();

//                    return $products->toJson();
                return $products;
            }

        }
    }

    public function getByPublish ($publish = null)
    {
        $products = Product::all();

        if ($publish == null){
            return $products;
        }
        elseif ($publish == 1){
            $pubs = Product::where("show",1)->get();

            return $pubs;
        }
        elseif ($publish == 0){
            $pubs = Product::where("show",0)->get();

            return $pubs;
        }
    }

    public function getByDeleted ($deleted = null)
    {
        $products = Product::all();

        if ($deleted == null){
            return $products;
        }
        elseif ($deleted == 1){
            $pubs = Product::where("deleted",1)->get();

            return $pubs;
        }
        elseif ($deleted == 0){
            $pubs = Product::where("deleted",0)->get();

            return $pubs;
        }
    }

    public function createProduct ($categories,$name,$price,$show = null,$deleted = null)
    {
        $categories = array_unique(explode(",",$categories));

        function checkCategorie($array)
        {
            $categories = Categorie::where(["deleted" => 0])->get(['id']);
            $categories = $categories->toArray();

            $newCategories = [];

            foreach ($categories as $category) {
                $newCategories[] = $category['id'];
            }

            $resultArray = [];

            foreach ($array as $arr) {
                if (in_array($arr,$newCategories)){ $resultArray[] = "YES"; }
                else{ $resultArray[] = "NO"; }
            }

            if (in_array("NO",$resultArray)){ return false; }
            else{ return true; }
        }

        if (count($categories) < 2){
            return "У вас недостаточно категорий (минимальное число - 2)";
        }
        elseif (count($categories) > 10){
            return "У вас слишком много категорий (максимальное число - 10)";
        }
        elseif (!checkCategorie($categories)){
            return "У вас ошибка в списке категорий, проверте правильность ввода";
        }
        else{

            $find = Product::where([
                ["name_product", "=",$name],
                ["price","=",$price],
            ])->get();

            if (count($find) > 0){
                return "Запись уже существует, измените данные";
            }
            else{

                Product::create([
                    "name_product"  => $name,
                    "price"         => $price,
                    "show"          => ($show == null || $show == 1) ? 1 : 0,
                    "deleted"       => ($deleted == null || $deleted == 0) ? 0 : 1,
                ]);

                $lastProduct = Product::orderBy("id","DESC")->first()->id;

                foreach ($categories as $category) {
                    Cat_prod::create([
                        "categories_id" => $category,
                        "product_id"    => $lastProduct
                    ]);
                }

                return "Товар успешно добавлен";
            }

        }
    }

    public function updateProduct ($id,$name,$price,$show = null,$deleted = null)
    {
        $product = Product::where([
            ["id","=",$id,],
            ["deleted","=","0",],
        ])->get();

        if (count($product) > 0){

            $product = $product[0];

            $product->name_product  = $name;
            $product->price         = $price;
            $product->show          = ($show == null || $show == 1) ? 1 : 0 ;
            $product->deleted       = ($deleted == null || $deleted == 0) ? 0 : 1 ; Cat_prod::where("product_id",$id)->update(['deleted' => 1]);
            $product->save();

            return "Товар обновлён";
        }
        else{
            return "Товар не найден";
        }
    }

    public function deleteProduct ($id)
    {
        $product = Product::where([
            ["id","=",$id],
            ["deleted","=",0],
        ])->get();

        if (count($product) > 0){

            $product = $product[0];

            $product->deleted = 1; Cat_prod::where("product_id",$id)->update(['deleted' => 1]);
            $product->save();

            return "Товар удалён";

        }
        else{
            return "Товар не найден";
        }
    }
}
