<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_receivers', function (Blueprint $table) {
            
            $table->bigIncrements('id')->comment('ID');
            $table->bigInteger('message_id')->unsigned()->comment('お知らせID');
            $table->integer('receiver_type')->comment('配信先タイプ');
            $table->integer('status')->default(0)->comment('ステータス');
            $table->bigInteger('school_id')->unsigned()->comment('学校ID');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_receivers');
    }
}
