<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->string('subject',255)->comment('タイトル');
            $table->text('body')->comment('本文');
            $table->bigInteger('sender')->unsigned()->comment('配信者');
            $table->bigInteger('receiver')->unsigned()->comment('配信先（クラスグループ）');
            $table->string('file',255)->nullable()->comment('ファイル');
            $table->integer('status')->comment('ステータス');

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
        Schema::dropIfExists('letters');
    }
}
