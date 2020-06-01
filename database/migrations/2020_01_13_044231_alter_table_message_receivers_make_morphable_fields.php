<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableMessageReceiversMakeMorphableFields extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('message_receivers', function (Blueprint $table) {
            $table->dropColumn('receiver_type');
        });

        Schema::table('message_receivers', function (Blueprint $table) {
            $table->morphs('receiver');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('message_receivers', function (Blueprint $table) {
            $table->dropMorphs('receiver');
        });

        Schema::table('message_receivers', function (Blueprint $table) {
            $table->integer('receiver_type')->comment('配信先タイプ');
        });
    }
}
