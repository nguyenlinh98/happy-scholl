<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDepartmentStudents extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('department_students', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('department_id')->unsigned()->comment('所属先ID');
            $table->bigInteger('student_id')->unsigned()->comment('クラスID');
            $table->bigInteger('school_id')->unsigned()->comment('学校ID');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('department_students');
    }
}
