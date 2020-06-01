<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            
            $table->string('key',255)->comment('キー');
            $table->string('display_name',255)->comment('表示名');
            $table->text('value')->nullable()->comment('設定値');
            $table->text('details')->nullable()->comment('詳細');
            $table->string('type',255)->nullable()->comment('タイプ');
            $table->integer('order')->nullable()->comment('ソート');
            $table->string('group',255)->nullable()->comment('グループ');


            
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
        Schema::dropIfExists('settings');
    }
}
