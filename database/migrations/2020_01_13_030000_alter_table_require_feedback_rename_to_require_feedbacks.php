<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AlterTableRequireFeedbackRenameToRequireFeedbacks extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::rename('require_feedback', 'require_feedbacks');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::rename('require_feedbacks', 'require_feedback');
    }
}
