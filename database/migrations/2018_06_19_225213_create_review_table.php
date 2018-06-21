<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReviewTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('review', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('taskId')->nullable();
			$table->integer('doerRating')->nullable();
			$table->text('doerReview', 65535)->nullable();
			$table->integer('taskDoerId')->nullable();
			$table->string('IsDoerFeedbackEntered', 10)->default('false');
			$table->integer('posterUserId')->nullable();
			$table->integer('posterRating')->nullable();
			$table->text('posterReview', 65535)->nullable();
			$table->string('IsPosterFeedbackEntered', 10)->default('false');
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
		Schema::drop('review');
	}

}
