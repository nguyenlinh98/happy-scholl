<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeminarRelationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('seminar_relation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('seminar_id')->unsigned();
            $table->morphs('relation');

            $table->foreign('seminar_id')->references('id')->on('seminars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('seminar_relation');
    }
}
