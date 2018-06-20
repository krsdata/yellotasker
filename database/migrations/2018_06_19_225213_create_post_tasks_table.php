<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_tasks', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title')->nullable();
			$table->string('description')->nullable();
			$table->string('locationType')->nullable();
			$table->text('address', 65535)->nullable();
			$table->string('zipcode')->nullable();
			$table->text('typeOfPeople', 65535)->nullable();
			$table->float('totalAmount', 10)->nullable()->default(0.00);
			$table->string('paymentMode')->nullable();
			$table->boolean('fund_released')->default(0);
			$table->string('funded_by_poster', 5)->default('No');
			$table->string('payment_status')->default('not initiated');
			$table->float('hourlyRate', 10)->nullable()->default(0.00);
			$table->string('totalHours')->nullable();
			$table->integer('userId')->nullable();
			$table->integer('categoryId')->nullable();
			$table->integer('taskDoerId')->unsigned()->nullable();
			$table->integer('taskOwnerId')->unsigned()->nullable();
			$table->date('dueDate')->nullable();
			$table->integer('peopleRequired')->nullable();
			$table->integer('budget')->nullable();
			$table->text('budgetType', 16777215)->nullable();
			$table->string('status')->default('open');
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
		Schema::drop('post_tasks');
	}

}
