<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrgentContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urgent_contacts', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->string('subject', 255)->comment('タイトル');
            $table->text('sender', 255)->comment('配信者');
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
        Schema::dropIfExists('urgent_contacts');
    }
}
