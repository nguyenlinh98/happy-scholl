<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStudentIdToRecycleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recycle_products', function (Blueprint $table) {
            $table->bigInteger('student_id')->unsigned()->comment('ユーザID')->change();
        });
        Schema::table('recycle_products', function (Blueprint $table) {
            $table->renameColumn('student_id', 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recycle_products', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->comment('学生ID')->change();
        });

        Schema::table('recycle_products', function (Blueprint $table) {
            $table->renameColumn('user_id', 'student_id');
        });
    }
}
