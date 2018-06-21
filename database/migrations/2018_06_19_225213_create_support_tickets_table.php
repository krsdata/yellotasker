<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSupportTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('support_tickets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->string('support_type')->nullable();
			$table->text('taskTitle', 65535)->nullable();
			$table->string('email')->nullable();
			$table->text('subject')->nullable();
			$table->text('description', 65535)->nullable();
			$table->text('reply', 65535)->nullable();
			$table->string('ticket_id')->nullable();
			$table->text('taskUrl', 65535)->nullable();
			$table->text('attachment', 65535)->nullable();
			$table->string('status')->nullable()->default('open');
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
		Schema::drop('support_tickets');
	}

}
