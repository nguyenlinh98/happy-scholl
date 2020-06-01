<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRecycleProductsAddRecyclePlaceId extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('recycle_products', function (Blueprint $table) {
            $table->bigInteger('recycle_place_id')->unsigned();
            //$table->foreign('recycle_place_id')->references('id')->on('recycle_places');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('recycle_products', function (Blueprint $table) {
            //$table->dropForeign(['recycle_place_id']);
            $table->dropColumn(['recycle_place_id']);
        });
    }
}
