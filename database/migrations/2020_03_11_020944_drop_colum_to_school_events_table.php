<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumToSchoolEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_events', function (Blueprint $table) {
            $table->dropColumn('deadline_at');
            $table->dropColumn('help_scheduled_at');
            $table->dropColumn('help_deadline_at');
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
            $table->timestamp('deadline_at')->nullable();
            $table->timestamp('help_scheduled_at');
            $table->timestamp('help_deadline_at');
        });
    }
}
