<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSoftDeleteExceptLetters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('user_calendar_themes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('class_groups', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('department_students', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('parent_students', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('passcodes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('require_feedbacks', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('require_feedbacks_receivers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('require_feedback_statuses', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('schools', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('school_passcodes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('students', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('user_calendar_display_settings', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('user_calendar_settings', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('user_calendar_themes', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('class_groups', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('department_students', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('parent_students', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('passcodes', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('require_feedbacks', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('require_feedbacks_receivers', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('require_feedback_statuses', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('schools', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('school_classes', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('school_passcodes', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('students', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('user_calendar_display_settings', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
        Schema::table('user_calendar_settings', function (Blueprint $table) {
            $table->softDeletes()->comment('削除日時');
        });
    }
}
