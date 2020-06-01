<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableRequireFeedbacksReceiversAddStatusColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('require_feedbacks_receivers', function (Blueprint $table) {
            $table->smallInteger('status')->default(0)->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('require_feedbacks_receivers', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->tinyInteger('status')->default(0);
        });
    }
}
