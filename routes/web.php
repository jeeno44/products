<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CategoriesController;
/*use App\Models\Categorie;
use App\Models\Product;
use App\Models\Cat_prod;*/

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

});
