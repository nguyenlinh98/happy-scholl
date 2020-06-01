<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSchoolAdminManages extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('school_admin_manages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->comment('ユーザID');
            $table->morphs('manage');
            $table->integer('class_teacher')->comment('担任');
            $table->bigInteger('school_id')->unsigned()->comment('学校ID');
            $table->timestamps();

            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('school_admin_manages');
    }
}
