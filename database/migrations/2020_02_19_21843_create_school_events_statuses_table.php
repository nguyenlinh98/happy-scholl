<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolEventsStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_events_statuses', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->bigInteger('school_event_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->integer('apply_status')->unsigned();
            $table->integer('apply_type')->unsigned();
            $table->bigInteger('school_id')->unsigned();

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
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
        Schema::dropIfExists('school_events_statuses');
    }
}
