<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecycleApplyStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recycle_apply_statuses', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->bigInteger('recycle_product_id')->unsigned()->comment('品番');
            $table->boolean('apply_status')->default(1)->nullable()->comment('申込ON/OFF');
            $table->bigInteger('student_id')->unsigned()->comment('学生ID');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recycle_apply_statuses');
    }
}
