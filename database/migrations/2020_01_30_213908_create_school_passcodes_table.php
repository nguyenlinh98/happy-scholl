<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolPasscodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_passcodes', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->bigInteger('school_id')->unsigned()->comment('学校ID');
            $table->string('passcode',255)->comment('パスコード');
            $table->integer('used')->default(0)->comment('使用済み');
            $table->timestamps();
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
        Schema::dropIfExists('school_passcodes');
    }
}
