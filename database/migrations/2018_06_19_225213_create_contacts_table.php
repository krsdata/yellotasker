<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title')->nullable();
			$table->string('position')->nullable();
			$table->string('firstName')->nullable();
			$table->string('lastName')->nullable();
			$table->string('name')->nullable();
			$table->string('email')->nullable();
			$table->string('mobile', 15)->nullable();
			$table->string('phone', 15)->nullable();
			$table->integer('categoryId')->unsigned()->nullable();
			$table->text('categoryName', 65535)->nullable();
			$table->integer('user_id')->unsigned()->nullable();
			$table->text('address', 65535)->nullable();
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
		Schema::drop('contacts');
	}

}
