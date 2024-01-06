<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('users_id')->nullable();
            $table->foreign('users_id')->on('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('products_id')->nullable();
            $table->foreign('products_id')->on('products')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('qty');
            $table->integer('subtotal');
            // send
            $table->string('name')->nullable();
            $table->foreignId('cities_id')->nullable();
            $table->foreign('cities_id')->on('cities')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->text('ekspedisi');
            $table->enum('status', ['0', '1', '2', '3']);
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}