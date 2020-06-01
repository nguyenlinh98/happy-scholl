<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTableDepartmentClasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('department_classes', function (Blueprint $table) {
            Schema::dropIfExists('department_classes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('department_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('department_id')->unsigned()->comment('所属先ID');
            $table->bigInteger('class_id')->unsigned()->comment('クラスID');
            $table->bigInteger('school_id')->unsigned()->comment('学校ID');
            $table->integer('display_order')->default('000')->comment('表示順');
            $table->timestamps();
            $table->softDeletes()->comment('削除日時');
        });
    }
}
