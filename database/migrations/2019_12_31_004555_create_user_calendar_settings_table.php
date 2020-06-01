<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCalendarSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_calendar_settings', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->bigInteger('user_id')->unsigned()->comment('ユーザID');
            $table->bigInteger('calendar_theme_id')->unsigned()->nullable()->comment('テーマID');
            $table->string('image1',255)->nullable()->comment('画像１');
            $table->string('image2',255)->nullable()->comment('画像２');
            $table->string('image3',255)->nullable()->comment('画像３');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->softDeletes()->comment('削除日時');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_calendar_settings');
    }
}
