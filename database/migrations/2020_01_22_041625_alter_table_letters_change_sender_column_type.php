<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableLettersChangeSenderColumnType extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->string('sender')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->integer('sender')->change();
        });
    }
}
