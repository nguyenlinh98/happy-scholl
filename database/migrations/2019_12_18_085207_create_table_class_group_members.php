<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableClassGroupMembers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('class_group_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('class_group_id');
            $table->bigInteger('school_class_id');
            $table->timestamps();
            $table->index('class_group_id')->references('id')->on('class_groups');
            $table->index('school_class_id')->references('id')->on('school_classes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('class_group_members');
    }
}
