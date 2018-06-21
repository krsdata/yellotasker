<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('task_id')->unsigned()->nullable();
			$table->string('task_title')->nullable();
			$table->string('payment_mode')->nullable();
			$table->boolean('status')->nullable();
			$table->integer('coupan_id')->unsigned()->nullable();
			$table->string('discount')->nullable();
			$table->float('total_price', 10)->nullable();
			$table->float('discount_price', 10)->nullable()->default(0.00);
			$table->string('transaction_id')->nullable();
			$table->text('order_id', 65535)->nullable();
			$table->text('order_details', 65535)->nullable();
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
		Schema::drop('orders');
	}

}
