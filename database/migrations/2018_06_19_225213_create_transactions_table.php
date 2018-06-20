<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transactions', function(Blueprint $table)
		{
			$table->integer('id')->unsigned();
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('product_id')->unsigned()->nullable();
			$table->string('product_name')->nullable();
			$table->integer('product_key_id')->unsigned()->nullable();
			$table->string('payment_mode')->nullable();
			$table->boolean('status')->nullable();
			$table->integer('coupan_id')->unsigned()->nullable();
			$table->string('discount')->nullable();
			$table->float('total_price', 10)->nullable();
			$table->float('discount_price', 10)->nullable()->default(0.00);
			$table->string('transaction_id')->nullable();
			$table->text('product_details', 65535)->nullable();
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
		Schema::drop('transactions');
	}

}
