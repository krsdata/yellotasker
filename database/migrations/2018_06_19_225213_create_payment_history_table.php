<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_history', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('userId')->nullable();
			$table->integer('taskId')->nullable();
			$table->decimal('amount', 10)->nullable()->default(0.00);
			$table->decimal('service_charge', 14)->default(0.00);
			$table->decimal('payable_amount', 14)->default(0.00);
			$table->string('mode', 100)->nullable();
			$table->string('currency', 10)->nullable();
			$table->text('remarks', 65535)->nullable();
			$table->boolean('status')->default(0);
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
		Schema::drop('payment_history');
	}

}
