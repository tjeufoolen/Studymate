<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLectureStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_student', function (Blueprint $table) {
            $table->primary(['lecture_id', 'student_id']);
            $table->unsignedBigInteger('lecture_id');
            $table->unsignedBigInteger('student_id');
            $table->string('file')->nullable();
            $table->float('grade')->nullable();
            $table->timestamp('graded_at')->nullable();
            $table->timestamp('submitted_at')->nullable();

            $table->foreign('lecture_id')
                ->references('id')
                ->on('lectures')
                ->onDelete('cascade');

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lecture_student', function(Blueprint $table) {
            $table->dropForeign('lecture_id');
            $table->dropForeign('student_id');
        });

        Schema::dropIfExists('lecture_student');
    }
}
