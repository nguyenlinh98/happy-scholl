<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUserCalendarDisplaySettingsChangeCalendarId extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('user_calendar_display_settings', function (Blueprint $table) {
            $table->string('calendar_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('user_calendar_display_settings', function (Blueprint $table) {
            $table->dropColumn(['calendar_id']);
        });
    }
}
