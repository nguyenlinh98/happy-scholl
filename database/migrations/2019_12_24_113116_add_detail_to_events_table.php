<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailToEventsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('title', 255)->comment('件名');
            $table->text('detail')->comment('詳細');
            $table->integer('type')->comment('タイプ');
            $table->timestamp('start')->nullable()->comment('開始日時');
            $table->timestamp('end')->nullable()->comment('完了日時');
            $table->text('location')->nullable()->comment('');
            $table->bigInteger('calendar_id')->unsigned()->comment('カレンダーID');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['title', 'detail', 'type', 'start', 'end', 'location', 'calendar_id']);
        });
    }
}
