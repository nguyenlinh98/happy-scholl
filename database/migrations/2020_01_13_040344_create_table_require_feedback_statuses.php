<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRequireFeedbackStatuses extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('require_feedback_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('require_feedback_id')->unsigned()->comment('フィードバックID');
            $table->bigInteger('student_id')->unsigned()->comment('学生ID');
            $table->smallInteger('feedback')->comment('フィードバック');
            $table->bigInteger('school_id')->unsigned()->comment('学校ID');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('require_feedback_id')->references('id')->on('require_feedbacks')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('require_feedback_statuses');
    }
}
