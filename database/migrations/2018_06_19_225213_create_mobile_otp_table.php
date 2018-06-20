<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMobileOtpTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mobile_otp', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('userId')->nullable();
			$table->string('otp')->nullable();
			$table->boolean('is_verified')->default(0);
			$table->string('timezone')->nullable();
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
		Schema::drop('mobile_otp');
	}

}
