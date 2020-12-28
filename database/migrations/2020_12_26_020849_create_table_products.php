<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // Описываем миграцию для создания таблицы продуктов

    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Имя продукта
            $table->string("name_product")->nullable(false);

            // Цена продукта
            $table->integer("price")->nullable(false); // Цена продукта

            // Показывается ли продукт (по умолчанию показывается)
            $table->smallInteger("show")->nullable(false)->default(1);

            // Удалён ли продукт (по умолчанию не удалён)
            $table->smallInteger("deleted")->nullable(false)->default(0);

            // Timestamp
            $table->timestamp("created_at")->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp("updated_at")->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
