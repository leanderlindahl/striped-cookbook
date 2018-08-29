<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipeTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_tag', function (Blueprint $table) {
						$table->increments('id');

						$table->integer('recipe_id')->unsigned();
						$table->foreign('recipe_id')->references('id')->on('recipes');

						$table->integer('tag_id')->unsigned();
						$table->foreign('tag_id')->references('id')->on('tags');					
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_tag');
    }
}
