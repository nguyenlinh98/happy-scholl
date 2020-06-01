<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSchoolSettingsTableAddForeignRelations extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('school_settings', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('school_settings', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });
    }
}
