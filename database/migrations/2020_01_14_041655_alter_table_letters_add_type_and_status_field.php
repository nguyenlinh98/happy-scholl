<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableLettersAddTypeAndStatusField extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->string('type')->default('GROUP');
            $table->tinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->dropColumn(['type', 'status']);
        });
    }
}
