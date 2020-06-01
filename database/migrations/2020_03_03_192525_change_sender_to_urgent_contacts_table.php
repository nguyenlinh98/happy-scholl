<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSenderToUrgentContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('urgent_contacts', function (Blueprint $table) {
            $table->string('sender', 255)->comment('配信者')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('urgent_contacts', function (Blueprint $table) {
            $table->text('sender', 255)->comment('配信者')->change();
        });
    }
}
