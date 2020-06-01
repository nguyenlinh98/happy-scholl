<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecycleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recycle_products', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->string('name',255)->comment('品名');
            $table->integer('product_status')->comment('ステータス');
            $table->text('detail')->nullable()->comment('詳細');
            $table->bigInteger('school_id')->unsigned()->comment('学校ID');
            $table->string('image1',255)->nullable()->comment('画像１');
            $table->string('image2',255)->nullable()->comment('画像２');
            $table->string('image3',255)->nullable()->comment('画像３');
            $table->string('image4',255)->nullable()->comment('画像４');
            $table->string('image5',255)->nullable()->comment('画像５');
            $table->integer('status')->default(1)->comment('ステータス');
            $table->bigInteger('student_id')->unsigned()->comment('学生ID');
            $table->timestamp('carrying_from_datetime')->nullable()->comment('持込日時（from）');
            $table->timestamp('carrying_to_datetime')->nullable()->comment('持込日時（to）');

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
        Schema::dropIfExists('recycle_products');
    }
}
