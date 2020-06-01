<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNullabelToSeminarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seminars', function (Blueprint $table) {
            $table->timestamp('start_time')->useCurrent();
            $table->timestamp('end_time')->useCurrent();
            $table->text('max_people')->nullable(false)->change();
            $table->timestamp('deadline_at')->useCurrent();
            $table->text('reason')->nullable(true)->change();
            $table->bigInteger('max_help_people')->change();
            $table->timestamp('help_scheduled_at')->useCurrent()->nullable(false);
            $table->timestamp('help_deadline_at')->useCurrent()->nullable(false);
            $table->timestamp('help_start_time')->useCurrent()->nullable(false);
            $table->timestamp('help_end_time')->useCurrent()->nullable(false);
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
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('max_people');
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
