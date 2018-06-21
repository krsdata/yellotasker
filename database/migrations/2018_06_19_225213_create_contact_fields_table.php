<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact_fields', function(Blueprint $table)
		{
			$table->integer('id')->unsigned();
			$table->integer('contactId')->unsigned()->nullable();
			$table->string('fieldKey')->nullable();
			$table->text('fieldValue', 65535)->nullable();
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
		Schema::drop('contact_fields');
	}

}
