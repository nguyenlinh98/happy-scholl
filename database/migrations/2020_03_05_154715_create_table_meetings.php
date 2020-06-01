<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMeetings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject');
            $table->text('body')->nullable();
            $table->string('sender');
            $table->string('zoom_link');
            $table->string('contact_email');
            $table->string('type');
            $table->tinyInteger('status');
            $table->bigInteger('school_id')->unsigned();
            $table->dateTime('scheduled_at');
            $table->softDeletes();

            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
}
