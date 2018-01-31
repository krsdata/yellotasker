<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAssignmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('assignments', function(Blueprint $table)
		{
			$table->foreign('course_id')->references('id')->on('courses')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('syllabus_id')->references('id')->on('syllabus')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('professor_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');;
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('assignments', function(Blueprint $table)
		{
			$table->dropForeign('assignments_course_id_foreign');
			$table->dropForeign('assignments_syllabus_id_foreign');
			$table->dropForeign('assignments_professior_id_foreign');
		});
	}

}
