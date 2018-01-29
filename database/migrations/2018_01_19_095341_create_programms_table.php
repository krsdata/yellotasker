<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProgrammsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('programms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('program_name')->nullable();
			$table->text('description', 65535)->nullable();
			$table->string('start_date')->nullable();
			$table->string('end_date')->nullable();
			$table->string('target_users')->nullable();
			$table->integer('complete_task')->nullable();
			$table->float('reward_point', 10, 0)->nullable();
			$table->integer('created_by')->nullable();
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
		Schema::drop('programms');
	}

}
