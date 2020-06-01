<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCalendarsAddEventBgcolorField extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->string('event_bgcolor')->comment('イベント背景色');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->dropColumn('event_bgcolor');
        });
    }
}
