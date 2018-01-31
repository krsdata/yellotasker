<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyllabusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syllabus', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('syllabus_title')->nullable();
            $table->string('syllabus_description')->nullable(); 
            $table->integer('course_id')->unsigned()->nullable(); 
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
       Schema::drop('syllabus');
    }
}
