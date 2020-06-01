<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->bigInteger('user_id')->unsigned()->comment('ユーザID');
            $table->integer('push_letter')->default(1)->comment('お手紙のプッシュ通知');
            $table->integer('push_notice')->default(1)->comment('お知らせのプッシュ通知');
            $table->integer('push_require_feedback')->default(1)->comment('回答必要通知のプッシュ通知');
            $table->integer('push_organization')->default(1)->comment('所属先のプッシュ通知');
            $table->integer('push_recycle')->default(1)->comment('リサイクルのプッシュ通知');
            $table->integer('push_happy_school_plus')->default(1)->comment('ハピスク＋のプッシュ通知');
            $table->integer('disp_happy_school_plus')->default(1)->comment('ハピスク＋の表示');

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
        Schema::dropIfExists('user_settings');
    }
}
