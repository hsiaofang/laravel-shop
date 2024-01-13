<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id'); 
            $table->string('name');
            $table->string('email');
            $table->text('cart');
            $table->boolean('paid')->default(0);
            $table->string('uuid');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
