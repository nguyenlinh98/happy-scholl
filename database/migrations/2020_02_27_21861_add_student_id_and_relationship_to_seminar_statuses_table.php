<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentIdAndRelationshipToSeminarStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seminar_statuses', function (Blueprint $table) {
            $table->integer('student_id')->unsigned();
            $table->string('relationship')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seminar_statuses', function (Blueprint $table) {
            $table->dropColumn(['student_id', 'relationship']);
        });
    }
}
