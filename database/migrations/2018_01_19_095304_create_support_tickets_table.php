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
			$table->integer('id')->unsigned();
			$table->integer('user_id')->unsigned()->nullable();
			$table->string('support_type')->nullable();
			$table->text('subject')->nullable();
			$table->text('description', 65535)->nullable();
			$table->string('ticket_id')->nullable();
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
