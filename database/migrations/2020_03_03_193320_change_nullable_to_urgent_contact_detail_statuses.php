<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNullableToUrgentContactDetailStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('urgent_contact_detail_statuses', function (Blueprint $table) {
            $table->string('question_id', 255)->change();
            $table->integer('question_type')->nullable()->change();
            $table->integer('yesno_answer')->nullable()->change();
            $table->string('question_text', 255)->change();
            $table->integer('status')->nullable()->comment('ステータス')->change();
            $table->string('answer_text', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('urgent_contact_detail_statuses', function (Blueprint $table) {
            $table->string('question_id', 255)->change();
            $table->string('question_text', 255)->change();
            $table->string('answer_text', 255)->change();
        });
    }
}
