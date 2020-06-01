<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToSchoolEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_events', function (Blueprint $table) {
            $table->string('help_email')->nullable(true);
            $table->string('help_tel')->nullable(true);
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
            $table->dropColumn('help_email');
            $table->dropColumn('help_tel');
        });
    }
}
