<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecyclePlaceIdToTableRecycleProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recycle_products', function (Blueprint $table) {
            // $table->bigInteger('recycle_place_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recycle_products', function (Blueprint $table) {
            // $table->dropColumn('recycle_place_id');
        });
    }
}
