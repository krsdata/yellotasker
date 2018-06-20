<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blogs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('blog_title', 16777215)->nullable();
			$table->text('blog_sub_title', 16777215)->nullable();
			$table->text('blog_description')->nullable();
			$table->string('blog_type')->nullable();
			$table->string('blog_category')->nullable();
			$table->text('blog_image', 16777215)->nullable();
			$table->string('blog_created_by')->nullable();
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
		Schema::drop('blogs');
	}

}
