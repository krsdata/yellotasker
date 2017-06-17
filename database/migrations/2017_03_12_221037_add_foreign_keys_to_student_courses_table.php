<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToStudentCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('student_courses', function(Blueprint $table)
		{
			$table->foreign('professor_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');;
			$table->foreign('student_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('student_courses', function(Blueprint $table)
		{
			$table->dropForeign('student_courses_professor_id_foreign');
			$table->dropForeign('student_courses_student_id_foreign');
		});
	}

}
