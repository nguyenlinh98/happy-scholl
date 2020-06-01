<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRequiredFeedbacksAddCleanUpDateColumn extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('require_feedbacks', function (Blueprint $table) {
            $table->date('clean_up_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('require_feedbacks', function (Blueprint $table) {
            $table->dropColumn(['clean_up_at']);
        });
    }
}
