<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCatProds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_prods', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("categories_id")->index()->unsigned()->nullable(false);
            $table->foreign('categories_id')->references('id')->on('categories');
            $table->bigInteger("product_id")->index()->unsigned()->nullable(false);
            $table->foreign('product_id')->references('id')->on('products');
            $table->timestamp("created_at")->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp("updated_at")->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unique(['categories_id','product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_prods');
    }
}
