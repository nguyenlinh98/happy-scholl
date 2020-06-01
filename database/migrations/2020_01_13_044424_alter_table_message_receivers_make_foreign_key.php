<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableMessageReceiversMakeForeignKey extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('message_receivers', function (Blueprint $table) {
            $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('message_receivers', function (Blueprint $table) {
            $table->dropForeign(['message_id']);
        });
    }
}
