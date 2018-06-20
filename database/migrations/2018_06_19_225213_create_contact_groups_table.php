<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact_groups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('groupName')->nullable();
			$table->string('groupCategory')->nullable();
			$table->integer('contactId')->unsigned()->nullable();
			$table->integer('parent_id')->nullable()->default(0);
			$table->string('email')->nullable();
			$table->string('name')->nullable();
			$table->string('phone')->nullable();
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
		Schema::drop('contact_groups');
	}

}
