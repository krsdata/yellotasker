<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('student_courses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('course_name')->nullable();
			$table->string('course_code')->nullable();
			$table->integer('professor_id')->nullable()->unsigned()->index('student_courses_professor_id_foreign');
			$table->integer('student_id')->nullable()->unsigned()->index('student_courses_student_id_foreign');
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
		Schema::drop('student_courses');
	}

}
