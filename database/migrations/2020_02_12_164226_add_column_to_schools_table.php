<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('namekana',255)->nullable()->comment('かな名');
            $table->string('postcode',255)->nullable()->comment('郵便番号');
            $table->string('prefectures',255)->nullable()->comment('都道府県');
            $table->string('address',255)->nullable()->comment('住所');
            $table->string('representative_emails',255)->nullable()->comment('代表者メールアドレス');
            $table->string('tel',255)->nullable()->comment('電話番号');
            $table->string('domain',255)->nullable()->comment('ドメイン');
            $table->timestamp('issue_date')->nullable()->comment('学校コード・パスコード発行日');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['namekana', 'postcode','prefectures','address','representative_emails','tel','domain','issue_date']);
        });
    }
}
