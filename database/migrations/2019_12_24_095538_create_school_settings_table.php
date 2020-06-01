<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_settings', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->bigInteger('school_id')->unsigned()->comment('学校ID');
            $table->integer('letter_active')->default(1)->comment('お手紙ON/OFF');
            $table->integer('notice_active')->default(1)->comment('お知らせON/OFF');
            $table->integer('require_feedback_active')->default(1)->comment('回答必要通知ON/OFF');
            $table->integer('organization_active')->default(1)->comment('カレンダーON/OFF');
            $table->integer('recycle_active')->default(1)->comment('リサイクルON/OFF');
            $table->integer('happy_school_plus_active')->default(1)->comment('物品購入ON/OFF');
            $table->integer('contact_book_active')->default(1)->comment('連絡網ON/OFF');
            $table->integer('urgent_contact_active')->default(1)->comment('緊急連絡ON/OFF');
            $table->integer('seminar_active')->default(1)->comment('講座ON/OFF');
            $table->integer('event_active')->default(1)->comment('イベントON/OFF');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_settings');
    }
}
