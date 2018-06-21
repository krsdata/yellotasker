<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->text('about_me', 65535)->nullable();
			$table->string('profile_image')->nullable();
			$table->string('phone', 20)->nullable();
			$table->string('role_type')->nullable();
			$table->string('email')->nullable();
			$table->string('password')->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->boolean('status')->default(1);
			$table->text('tagLine', 65535)->nullable();
			$table->string('location')->nullable();
			$table->string('birthday')->nullable();
			$table->text('skills', 65535)->nullable();
			$table->string('modeOfreach')->nullable();
			$table->string('language')->nullable();
			$table->string('qualification')->nullable();
			$table->string('workExperience')->nullable();
			$table->string('percentageCompletion')->nullable();
			$table->boolean('rating')->default(4);
			$table->float('current_balance', 10)->default(0.00);
			$table->float('total_balance', 10)->default(0.00);
			$table->string('skill_completion')->nullable();
			$table->string('profile_completion')->nullable();
			$table->string('badges')->nullable();
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
		Schema::drop('users');
	}

}
