<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProfessorProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('professor_profiles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('designation')->nullable();
			$table->string('office_hours')->nullable();
			$table->string('location')->nullable();
			$table->text('email', 65535)->nullable();
			$table->integer('professor_id')->unsigned()->index('professor_profiles_professor_id_foreign');
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
		Schema::drop('professor_profiles');
	}

}
