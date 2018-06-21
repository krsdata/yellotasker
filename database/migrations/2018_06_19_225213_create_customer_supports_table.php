<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerSupportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_supports', function(Blueprint $table)
		{
			$table->integer('id');
			$table->string('contact_person')->nullable();
			$table->string('support_type')->nullable();
			$table->string('support_number')->nullable();
			$table->string('support_email')->nullable();
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
		Schema::drop('customer_supports');
	}

}
