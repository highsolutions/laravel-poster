<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaravelPosterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('laravel_posters', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('social', 50);
            $table->string('address', 200);
            $table->text('text');
            $table->string('identifier', 100);
            $table->dateTime('posted_at');
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
        Schema::dropIfExists('laravel_posters');
	}

}
