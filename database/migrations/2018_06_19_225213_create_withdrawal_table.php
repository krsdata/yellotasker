<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWithdrawalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('withdrawal', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('txn_id', 256)->nullable();
			$table->integer('userId')->nullable();
			$table->float('amount', 10)->nullable();
			$table->decimal('service_charge', 14)->default(0.00);
			$table->decimal('payable_amount', 14)->default(0.00);
			$table->text('remarks', 65535)->nullable();
			$table->text('paymentMethod', 65535)->nullable();
			$table->text('api_response', 65535)->nullable();
			$table->boolean('status')->default(0);
			$table->string('currency', 10)->nullable();
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
		Schema::drop('withdrawal');
	}

}
