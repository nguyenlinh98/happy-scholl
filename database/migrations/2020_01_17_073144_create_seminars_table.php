<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeminarsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('seminars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject');
            $table->text('body');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->string('address');
            $table->string('instructor');
            $table->bigInteger('fee')->unsigned();
            $table->string('image1',255)->nullable();
            $table->string('image2',255)->nullable();
            $table->string('image3',255)->nullable();
            $table->text('max_people')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('deadline_at')->nullable();
            $table->string('email')->nullable();
            $table->string('tel')->nullable();
            $table->tinyInteger('need_help')->default(0);
            $table->text('reason');
            $table->bigInteger('max_help_people');
            $table->timestamp('help_scheduled_at')->useCurrent();
            $table->timestamp('help_deadline_at')->useCurrent();
            $table->timestamp('help_start_time')->useCurrent();
            $table->timestamp('help_end_time')->useCurrent();
            $table->string('help_email',255)->nullable();
            $table->string('help_tel',255)->nullable();
            $table->string('sender');
            $table->tinyInteger('status')->default(0);
            $table->bigInteger('school_id')->unsigned();

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
        Schema::dropIfExists('seminars');
    }
}
