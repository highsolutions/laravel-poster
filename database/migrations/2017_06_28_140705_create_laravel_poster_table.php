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
        Schema::create('lp_posts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('social', 50);
            $table->string('address', 200);
            $table->text('text');
            $table->string('identifier', 100);
            $table->dateTime('posted_at');
            $table->timestamps();
        });

        Schema::create('lp_tokens', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('social', 50);
            $table->string('token', 200);
            $table->dateTime('expired_at');
            $table->dateTime('notified_at')->nullable();
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
        Schema::dropIfExists('lp_posts');
        Schema::dropIfExists('lp_tokens');
	}

}
