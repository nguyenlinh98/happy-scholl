<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableLettersAddScheduledAt extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->dateTime('scheduled_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->dropColumn('scheduled_at');
        });
    }
}
