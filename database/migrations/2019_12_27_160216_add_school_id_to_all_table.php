<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSchoolIdToAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('letters', function (Blueprint $table) {
        //     $table->bigInteger('school_id')->unsigned()->comment('学校ID');
        // });
        // Schema::table('recycles', function (Blueprint $table) {
        //     $table->bigInteger('school_id')->unsigned()->comment('学校ID');
        // });
        // Schema::table('student_settings', function (Blueprint $table) {
        //     $table->bigInteger('school_id')->unsigned()->comment('学校ID');
        // });

        // Schema::table('messages', function (Blueprint $table) {
        //     $table->bigInteger('school_id')->unsigned()->comment('学校ID');
        // });
        // Schema::table('corporates', function (Blueprint $table) {
        //     $table->bigInteger('school_id')->unsigned()->comment('学校ID');
        // });

        Schema::table('school_classes', function (Blueprint $table) {
            $table->bigInteger('school_id')->unsigned()->comment('学校ID');
        });
        Schema::table('class_groups', function (Blueprint $table) {
            $table->bigInteger('school_id')->unsigned()->comment('学校ID');
        });
        Schema::table('students', function (Blueprint $table) {
            $table->bigInteger('school_id')->unsigned()->comment('学校ID');
        });
        Schema::table('user_devices', function (Blueprint $table) {
            $table->bigInteger('school_id')->unsigned()->comment('学校ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('letters', function (Blueprint $table) {
        //     $table->dropColumn(['school_id']);
        // });
        // Schema::table('require_feedbacks', function (Blueprint $table) {
        //     $table->dropColumn(['school_id']);
        // });
        // Schema::table('recycles', function (Blueprint $table) {
        //     $table->dropColumn(['school_id']);
        // });
        // Schema::table('student_settings', function (Blueprint $table) {
        //     $table->dropColumn(['school_id']);
        // });
        // Schema::table('admin_settings', function (Blueprint $table) {
        //     $table->dropColumn(['school_id']);
        // });
        // Schema::table('school_settings', function (Blueprint $table) {
        //     $table->dropColumn(['school_id']);
        // });
        // Schema::table('calendars', function (Blueprint $table) {
        //     $table->dropColumn(['school_id']);
        // });
        // Schema::table('messages', function (Blueprint $table) {
        //     $table->dropColumn(['school_id']);
        // });
        // Schema::table('corporates', function (Blueprint $table) {
        //     $table->dropColumn(['school_id']);
        // });
        // Schema::table('teachers', function (Blueprint $table) {
        //     $table->dropColumn(['school_id']);
        // });
        // Schema::table('school_classes', function (Blueprint $table) {
        //     $table->dropColumn(['school_id']);
        // });
        // Schema::table('class_groups', function (Blueprint $table) {
        //     $table->dropColumn(['school_id']);
        // });
        // Schema::table('students', function (Blueprint $table) {
        //     $table->dropColumn(['school_id']);
        // });
        // Schema::table('user_devices', function (Blueprint $table) {
        //     $table->dropColumn(['school_id']);
        // });
    }
}
