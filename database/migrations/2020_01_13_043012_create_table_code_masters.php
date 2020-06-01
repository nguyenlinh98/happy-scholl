<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCodeMasters extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('code_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('group_code')->comment('グループコード');
            $table->string('group_name')->comment('グループ名');
            $table->char('display_order', 3)->comment('表示順')->default('000');
            $table->string('name')->comment('名称');
            $table->bigInteger('code')->comment('コード');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('code_masters');
    }
}
