<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->integer('stock');
            $table->integer('weight')->nullable();
            $table->integer('price');
            $table->foreignId('categories_id')->nullable();
            $table->foreign('categories_id')->on('categories')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('users_id')->nullable();
            $table->foreign('users_id')->on('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
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