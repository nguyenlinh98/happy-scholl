<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRequiredFeedbacksChangeSenderType extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('require_feedbacks', function (Blueprint $table) {
            $table->string('sender')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('require_feedbacks', function (Blueprint $table) {
            $table->bigInteger('sender')->change();
        });
    }
}
