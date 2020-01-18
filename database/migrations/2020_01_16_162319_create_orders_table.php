<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('SalePerson')->unsigned();
            $table->foreign('SalePerson')->references('owner')->on('items')->onDelete('cascade');
            $table->bigInteger('BuyerID')->unsigned();
            $table->foreign('BuyerID')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('ProductID')->unsigned();
            $table->foreign('ProductID')->references('id')->on('items')->onDelete('cascade');
            $table->integer('quantity')->unsigned();
            $table->boolean('IsDeleivered')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
