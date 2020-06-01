<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecyclePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recycle_places', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->bigInteger('place')->unsigned()->comment('場所');
            $table->boolean('school_id')->comment('学校ID');
            $table->bigInteger('date')->unsigned()->nullable()->comment('日付記載');
            $table->bigInteger('time')->unsigned()->nullable()->comment('時間記載');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recycle_places');
    }
}
