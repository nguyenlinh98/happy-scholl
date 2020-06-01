<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolEventsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('school_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject');
            $table->text('body');
            $table->text('max_people');
            $table->string('sender');
            $table->tinyInteger('status')->default(0);
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('deadline_at')->nullable();
            $table->tinyInteger('need_help')->default(0);
            $table->text('reason');
            $table->bigInteger('max_help_people');
            $table->timestamp('help_scheduled_at')->useCurrent();
            $table->timestamp('help_deadline_at')->useCurrent();
            $table->string('image1',255)->nullable();
            $table->string('image2',255)->nullable();
            $table->string('image3',255)->nullable();
            $table->bigInteger('school_id')->unsigned();
            $table->string('email')->nullable();
            $table->string('tel')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('school_events');
    }
}
