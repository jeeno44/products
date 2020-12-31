<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;

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

    // Группа категорий
    Route::group(['prefix' => 'categories'],function (){

        // Показать все категорий
        // Показать конкретную категорию по id пример show/2
        Route::get('show/{id?}', [CategoriesController::class,"getAll"]);

        // Создание категории
        // http://localhost:8000/api/categories/create/{name}
        // где name - имя категории
        Route::post('create/{name}', [CategoriesController::class,"createCategorie"]);

        // Обновление категории
        // http://localhost:8000/api/categories/update/{id}/{name}
        // где
        //      id идентификатор категории
        //      name имя категории
        Route::patch('update/{id}/{name}', [CategoriesController::class,"updateCategorie"]);

        // Удаление категрии
        // http://localhost:8000/api/categories/delete/{id}
        // где id идентификатор категории
        // категория не удаляется, а помечается как удалённая
        Route::delete('delete/{id}', [CategoriesController::class,"deleteCategorie"]);

    });
    // Группа товаров
    Route::group(['prefix' => 'products'],function (){
        // Выборка товаров (Выполняетеся методом GET)
        // http://localhost:8000/api/products/show/{id?}
        // где id - необязательный параметр
        // если параметра id нет, то показываются все неудалённые товары, то есть с парметром deleted = 0
        // если параметр id есть, то показывается записть с этим id, если запись не удалена, то есть у записи deleted = 0
        // в противном случае запись не будет найдена
        Route::get('show/{id?}',[ProductsController::class,"getAll"]);

        // Выборка товаров по имени (Выполняетеся методом GET)
        // http://localhost:8000/api/products/name/{name?}
        // где
        //    name - имя товара (обязательный параметр)
        // под совпадении попадут любые товары с ключевым словом {name} и если запись не удалена
        // в противном случае запись не будет найдена
        Route::get('name/{name}',[ProductsController::class,"getByName"]);

        // Выборка товаров по имени категории (Выполняетеся методом GET)
        // http://localhost:8000/api/products/category/{category}
        // где
        //    category - имя категории (обязательный параметр)
        // под совпадении выведутся все товары этой категории
        // если у категории нет товаром, то выведется сообщение об отсутствии товаров данной категории
        Route::get('category/{category}',[ProductsController::class,"getByCategory"]);

        // Выборка товаров по цене товаров (Выполняетеся методом GET)
        // http://localhost:8000/api/products/price/{price}
        // где
        //    price - диапазон цен товаров через дефис (обязательный параметр) прим 200-500
        // под совпадении выведутся все товары попадающие в этот диапазон
        Route::get('price/{price}',[ProductsController::class,"getByPrice"]);

        // Выборка товаров по статусу публикации товаров (Выполняетеся методом GET)
        // http://localhost:8000/api/products/publish/{publish}
        // где
        //    publish - необязательный параметр (1 или 0)
        // если параметра publish нет то выведутся все товары
        // если publish = 1 выведутся все опубликованные товары
        // если publish = 0 выведутся все неопубликованные товары
        Route::get('publish/{publish?}',[ProductsController::class,"getByPublish"]);

        // Выборка товаров по статусу удаления товаров (Выполняетеся методом GET)
        // http://localhost:8000/api/products/deleted/{deleted}
        // где
        //    deleted - необязательный параметр (1 или 0)
        // если параметра deleted нет то выведутся все товары
        // если deleted = 1 выведутся все удалённые товары
        // если deleted = 0 выведутся все не удалённые товары
        Route::get('deleted/{deleted?}',[ProductsController::class,"getByDeleted"]);

        // Создание товара (Выполняетеся методом POST)
        // http://localhost:8000/api/products/create/{categories}/{name}/{price}/{show?}/{deleted?}
        // где
        //      {categories} - категории товара через запятую (1,2,3 и т.д.)
        //      {name} - имя товара
        //      {price} - цена товара
        //      {show?} - необязательный параметр "опубликовано" (по умолчанию = 1 опубликовано)
        //      {deleted?} - необязательный параметр "удалено" (по умолчанию = 0 не удалено)
        Route::post('create/{categories}/{name}/{price}/{show?}/{deleted?}',[ProductsController::class,"createProduct"]);

        // Обновление товара (Выполняетеся методом PATCH)
        // http://localhost:8000/api/products/update/{id}/{name}/{price}/{show?}/{deleted?}
        // где
        //      {id} - идентификатор товара
        //      {name} - имя товара
        //      {price} - цена товара
        //      {show?} - необязательный параметр "опубликовано" (по умолчанию = 1 опубликовано)
        //      {deleted?} - необязательный параметр "удалено" (по умолчанию = 0 не удалено)
        Route::patch('update/{id}/{name}/{price}/{show?}/{deleted?}',[ProductsController::class,'updateProduct']);

        // Удаление товара (Выполняетеся методом DELETE)
        // http://localhost:8000/api/products/delete/{id}
        // где
        //      {id} - идентификатор товара (товар не удаляется из базы, а только помечается как удалённый)
        Route::delete('delete/{id}',[ProductsController::class,"deleteProduct"]);

    });

});
