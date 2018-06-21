<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->nullable();
			$table->string('title')->nullable();
			$table->string('message')->nullable();
			$table->integer('notified_user')->nullable();
			$table->integer('entity_id')->nullable()->comment('eg. task id, Comment id');
			$table->enum('entity_type', array('task_add','task_update','task_delete','comment_add','comment_replied','comment_delete','user_register','offers_add','offers_update','offers_delete'))->nullable();
			$table->boolean('status')->default(1);
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
		Schema::drop('notifications');
	}

}
