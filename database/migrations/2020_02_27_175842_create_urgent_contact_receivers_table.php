<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrgentContactReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urgent_contact_receivers', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->morphs('receiver');
            $table->bigInteger('urgent_contact_id')->unsigned()->comment('緊急連絡ID');
            $table->tinyInteger('status')->default(0)->comment('ステータス');
            $table->bigInteger('school_id')->unsigned()->comment('学校ID');

            $table->timestamp('created_at')->useCurrent()->comment('作成日時');
            $table->timestamp('updated_at')->useCurrent()->comment('更新日時');

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
        Schema::dropIfExists('urgent_contact_receivers');
    }
}
