<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableRequireFeedbacksAddStatusColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('require_feedbacks', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0);
            $table->dateTime('scheduled_at')->useCurrent();
            $table->dateTime('deadline');
            $table->text('sender')->comment('配信者');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('require_feedbacks', function (Blueprint $table) {
            $table->dropColumn(['status','scheduled_at', 'deadline', 'sender']);
        });
    }
}
