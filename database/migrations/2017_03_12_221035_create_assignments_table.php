<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAssignmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assignments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('course_id')->unsigned()->nullable()->index('assignments_course_id_foreign');
			$table->integer('syllabus_id')->unsigned()->nullable()->index('assignments_syllabus_id_foreign');  
			$table->string('paper_title')->nullable();
			$table->string('duration')->nullable();
			$table->string('chapter')->nullable();
			$table->string('type')->nullable();
			$table->text('description', 65535)->nullable();
			$table->char('grade', 1)->nullable();
			$table->integer('marks')->nullable();
			$table->integer('professor_id')->unsigned()->nullable()->index('assignments_professor_id_foreign');
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
		Schema::drop('assignments');
	}

}
