<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CategoriesController;
use App\Models\Categorie;
use App\Models\Product;
use App\Models\Cat_prod;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => '/'],function (){

    // Главная точка входа
    Route::get('', [IndexController::class,"index"]);

});

Route::group(['prefix' => 'api'],function (){

    Route::group(['prefix' => 'categories'],function (){

        Route::get('show/{id?}', [CategoriesController::class,"getAll"]);

        Route::post('create/{name}', [CategoriesController::class,"createCategorie"]);

        Route::patch('update/{id}/{name}', [CategoriesController::class,"updateCategorie"]);

        Route::delete('delete/{id}', [CategoriesController::class,"deleteCategorie"]);

    });

    Route::group(['prefix' => 'products'],function (){

        Route::post('create/{categorie}/{name}/{price}/{show?}/{deleted?}',function ($categorie,$name,$price,$show = null,$deleted = null){

            $categories = array_unique(explode(",",$categorie));

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
                        "show"          => ($show == null) ? 1 : 0,
                        "deleted"       => ($deleted == null) ? 0 : 1,
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

        });

        Route::patch('update/{id}/{name}/{price}/{show?}/{deleted?}',function ($id,$name,$price,$show = null,$deleted = null){

            $product = Product::where([
                ["id","=",$id,],
                ["deleted","=","0",],
            ])->get();

            if (count($product) > 0){

                $product = $product[0];

                $product->name_product  = $name;
                $product->price         = $price;
                $product->show          = ($show == null || $deleted == 1) ? 1 : 0 ;
                $product->deleted       = ($deleted == null || $deleted == 0) ? 0 : 1 ; Cat_prod::where("product_id",$id)->update(['deleted' => 1]);
                $product->save();

                return "Товар обновлён";
            }
            else{
                return "Товар не найден";
            }

        });

        Route::delete('delete/{id}',function ($id){

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

        });

    });

});
