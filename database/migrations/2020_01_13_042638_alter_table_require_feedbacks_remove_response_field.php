<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRequireFeedbacksRemoveResponseField extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('require_feedbacks', function (Blueprint $table) {
            $table->dropColumn(['response']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('require_feedbacks', function (Blueprint $table) {
            $table->bigInteger('response')->unsigned()->comment('可否');
        });
    }
}
