<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableLetterReceiversMakeMorphableFields extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('letter_receivers', function (Blueprint $table) {
            $table->dropColumn('receiver_type');
        });

        Schema::table('letter_receivers', function (Blueprint $table) {
            $table->morphs('receiver');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('letter_receivers', function (Blueprint $table) {
            $table->dropMorphs('receiver');
        });

        Schema::table('letter_receivers', function (Blueprint $table) {
            $table->integer('receiver_type')->comment('配信先タイプ');
        });
    }
}
