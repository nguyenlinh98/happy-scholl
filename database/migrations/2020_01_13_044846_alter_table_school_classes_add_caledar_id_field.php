<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSchoolClassesAddCaledarIdField extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->bigInteger('calendar_id')->unsigned()->comment('デフォルトカレンダーID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropColumn('calendar_id');

        });
    }
}
