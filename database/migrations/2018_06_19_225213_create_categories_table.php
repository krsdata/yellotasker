<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('slug')->nullable();
			$table->string('category_name')->nullable();
			$table->string('category_group_name')->nullable();
			$table->text('category_group_image', 65535)->nullable();
			$table->string('category_image')->nullable();
			$table->text('description', 65535)->nullable();
			$table->integer('parent_id')->nullable();
			$table->integer('level')->unsigned()->nullable()->default(1);
			$table->boolean('status')->nullable()->default(1);
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
		Schema::drop('categories');
	}

}
