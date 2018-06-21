<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticleTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_type', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('article_type')->nullable();
			$table->enum('resolution_department', array('billing team','sales team','technical team','admin team','support team'))->nullable();
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
		Schema::drop('article_type');
	}

}
