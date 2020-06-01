<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNullableToSchoolEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_events', function (Blueprint $table) {
            $table->timestamp('start_time')->useCurrent();;
            $table->timestamp('end_time')->useCurrent();;
            $table->string('address');
            $table->string('instructor');
            $table->bigInteger('fee');
            $table->text('reason')->nullable(true)->change();
            $table->timestamp('deadline_at')->useCurrent();;
            $table->bigInteger('max_help_people')->change();
            $table->timestamp('help_scheduled_at')->nullable();
            $table->timestamp('help_deadline_at')->nullable();
            $table->timestamp('help_start_time')->nullable();
            $table->timestamp('help_end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_events', function (Blueprint $table) {
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('address');
            $table->dropColumn('instructor');
            $table->dropColumn('fee');
            $table->dropColumn('deadline_at');
            $table->dropColumn('reason');
            $table->dropColumn('max_help_people');
            $table->dropColumn('help_scheduled_at');
            $table->dropColumn('help_deadline_at');
            $table->dropColumn('help_start_time');
            $table->dropColumn('help_end_time');
        });
    }
}
