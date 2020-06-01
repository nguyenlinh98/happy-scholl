<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeOfCollumToRecyclePlaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recycle_places', function (Blueprint $table) {
            $table->text('place')->change();
            $table->string('date')->change();
            $table->string('time')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recycle_places', function (Blueprint $table) {
            $table->bigInteger('place')->change();
            $table->bigInteger('date')->change();
            $table->bigInteger('time')->change();
        });
    }
}
