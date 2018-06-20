<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->integer('id')->unsigned();
			$table->string('product_title')->nullable();
			$table->integer('product_category')->unsigned()->nullable();
			$table->integer('product_sub_category')->unsigned()->nullable();
			$table->float('price', 10)->nullable();
			$table->integer('qty')->unsigned()->nullable()->default(1);
			$table->float('discount', 10)->default(0.00);
			$table->text('description', 16777215)->nullable();
			$table->text('photo', 16777215)->nullable();
			$table->string('product_type')->nullable();
			$table->integer('validity')->unsigned()->nullable();
			$table->integer('product_key_id')->unsigned()->nullable();
			$table->integer('total_stocks')->unsigned()->nullable();
			$table->integer('available_stocks')->unsigned()->nullable();
			$table->integer('views')->unsigned()->nullable()->default(1);
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
		Schema::drop('products');
	}

}
