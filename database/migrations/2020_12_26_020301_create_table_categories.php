<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    // Описываем миграцию для создания таблицы "Категории"

    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // Имя категории
            $table->string("name_categories")->nullable(false)->unique("name");

            // Удалена ли категория (по умолчанию не удалена (0))
            $table->string("deleted")->nullable(false)->default(0);

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
        Schema::dropIfExists('categories');
    }
}
