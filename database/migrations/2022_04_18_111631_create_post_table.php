<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id') ;
            $table->string('title') ;
            $table->text('body') ;
            $table->enum('category' , ['Economic' , 'Political' , 'Sport']) ;
            $table->integer('view')->nullable() ;
            $table->unsignedBigInteger('user_id') ;
            $table->timestamps() ;
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade') ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
