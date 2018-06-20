<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('offers', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('taskId')->nullable();
			$table->integer('assignUserId')->nullable();
			$table->integer('interestedUserId')->unsigned()->nullable();
			$table->text('comment', 65535)->nullable();
			$table->float('offerPrice', 10)->default(0.00);
			$table->string('completionDate')->nullable();
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
		Schema::drop('offers');
	}

}
