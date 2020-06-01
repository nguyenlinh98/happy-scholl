<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableLetterReceiversMakeForeignKey extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('letter_receivers', function (Blueprint $table) {
            $table->foreign('letter_id')->references('id')->on('letters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('letter_receivers', function (Blueprint $table) {
            $table->dropForeign(['letter_id']);
        });
    }
}
