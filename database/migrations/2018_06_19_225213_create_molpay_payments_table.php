<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMolpayPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('molpay_payments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->decimal('amount', 10)->nullable();
			$table->string('order_id');
			$table->string('app_code')->nullable();
			$table->integer('transaction_id')->index();
			$table->string('domain');
			$table->string('status', 2);
			$table->string('currency', 2);
			$table->date('paid_at');
			$table->string('channel');
			$table->string('error_code')->nullable();
			$table->string('error_description')->nullable();
			$table->string('security_key', 32)->nullable();
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
		Schema::drop('molpay_payments');
	}

}
