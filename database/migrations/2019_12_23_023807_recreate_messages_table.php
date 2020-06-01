<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('messages');

        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->string('subject')->comment('タイトル');
            $table->text('body')->comment('本文');
            $table->text('sender')->comment('配信者');
            $table->bigInteger('receiver')->comment('配信先（クラスグループ）');
            $table->text('file')->nullable()->comment('ファイル');
            $table->tinyInteger('status')->comment('ステータス');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
