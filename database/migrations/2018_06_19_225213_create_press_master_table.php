<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePressMasterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('press_master', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('pressName')->nullable();
			$table->text('link', 65535)->nullable();
			$table->text('articleDescription', 65535)->nullable();
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
		Schema::drop('press_master');
	}

}
