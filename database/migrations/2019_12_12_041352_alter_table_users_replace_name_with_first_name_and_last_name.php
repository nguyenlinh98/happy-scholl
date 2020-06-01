<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsersReplaceNameWithFirstNameAndLastName extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name']);
            $table->string('first_name');
            $table->string('last_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'first_name')) {
                $table->dropColumn(['first_name']);
            }

            if (Schema::hasColumn('users', 'last_name')) {
                $table->dropColumn(['last_name']);
            }

            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name');
            }
        });
    }
}
