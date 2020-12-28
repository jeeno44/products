<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Models\Categorie;
use App\Models\Product;

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

    /*Route::group(['prefix' => 'create'],function (){

            Route::get('categories',function (){

                return "Создаём категорию";

            });

    });

    Route::group(['prefix' => 'show'],function (){

            Route::get('categories/{num?}',function (){

                return response()->json(\App\Models\Categorie::all());

            });

    });*/

    Route::group(['prefix' => 'categories'],function (){

        Route::get('show/{id?}',function ($id = null){

            if (!$id){

                $allCategories = Categorie::all();

                return $allCategories->toJson();
            }
            else{

                $categorie = Categorie::where(["id" => $id])->get();

                if (count($categorie) == 0){
                    return "Категория не найдена";
                }
                else{
                    return $categorie->toJson();
                }
            }

        });

        Route::post('create/{name}',function ($name){

            $find = Categorie::where(["name_categories" => $name])->get();

            if (count($find) == 0){
                Categorie::create(['name_categories' => $name]);

                return "Категория добавлена";
            }
            else{
                return "Категория уже сужествует";
            }

        });

        Route::patch('update/{id}/{name}',function ($id,$name){

            $categorie = Categorie::where(["id" => $id])->get();

            if (count($categorie) == 0){
                return "Категория не найдена";
            }
            else{
                $categorie[0]->name_categories = $name;
                $categorie[0]->save();
                return "Категория обновлена";
            }

            /*$categorie = Categorie::where(["id" => $id])->get();

            if (count($categorie) == 0){
                return "Категория не найдена";
            }
            else{
                return $categorie;
            }*/

        });

        Route::delete('delete/{id}',function ($id){

            $categorie = Categorie::where(["id" => $id])->get();

            if (count($categorie) == 0){
                return "Категория не найдена";
            }
            else{

                $dels = $categorie[0];
//                $products = $dels->Products()->name_product;

//                return $products;
                return $id;
            }

        });

        Route::get('del/{id}',function ($id){

            $categorie = Categorie::where(["id" => $id])->get();

            if (count($categorie) == 0){
                return "Категория не найдена";
            }
            else{

//                $dels = $categorie[0];
//                $products = $dels->Products()->name_product;

                $cats = Categorie::all();

                foreach ($cats as $cat) {

                    dump($cat->PProducts()->id);

                }

            }

        });

    });

});
