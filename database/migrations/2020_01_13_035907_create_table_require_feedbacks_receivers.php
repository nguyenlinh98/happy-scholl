<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRequireFeedbacksReceivers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('require_feedbacks_receivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('receiver');
            $table->bigInteger('require_feedback_id')->unsigned()->comment('フィードバックID');
            $table->bigInteger('school_id')->unsigned();
            $table->smallInteger('status')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('require_feedback_id')->references('id')->on('require_feedbacks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('require_feedbacks_receivers');
    }
}
