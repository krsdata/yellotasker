<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComplainsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('complains', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('reasonId')->nullable();
			$table->text('comment', 65535)->nullable();
			$table->text('reasonDescription', 65535)->nullable();
			$table->integer('reportedUserId')->nullable();
			$table->integer('postedUserId')->nullable();
			$table->integer('taskId')->nullable();
			$table->string('compainId')->nullable();
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
		Schema::drop('complains');
	}

}
