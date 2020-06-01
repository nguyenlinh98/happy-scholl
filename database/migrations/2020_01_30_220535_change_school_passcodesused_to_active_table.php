<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSchoolPasscodesusedToActiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_passcodes', function (Blueprint $table) {
            $table->renameColumn('used', 'active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_passcodes', function (Blueprint $table) {
            $table->renameColumn('active', 'used')->default(0);
        });
    }
}
