<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnToSeminarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seminars', function (Blueprint $table) {
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('deadline_at');
            $table->dropColumn('help_scheduled_at');
            $table->dropColumn('help_deadline_at');
            $table->dropColumn('help_start_time');
            $table->dropColumn(['help_end_time']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seminars', function (Blueprint $table) {
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->timestamp('deadline_at');
            $table->timestamp('help_scheduled_at')->nullable();
            $table->timestamp('help_deadline_at')->nullable();
            $table->timestamp('help_start_time')->nullable();
            $table->timestamp('help_end_time')->nullable();
        });
    }
}
