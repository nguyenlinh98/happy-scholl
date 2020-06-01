<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CodeMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $codeMasters = [
            ['1001', '商品状態', '010', '01', '新品、未使用'],
            ['1001', '商品状態', '020', '02', '未使用に近い'],
            ['1001', '商品状態', '030', '03', '目立った傷や汚れあり'],
            ['1001', '商品状態', '040', '04', 'やや傷や汚れあり'],
            ['1001', '商品状態', '050', '05', '傷や汚れあり'],
            ['1001', '商品状態', '060', '06', '全体的に状態が悪い'],
            ['1002', '関係', '010', '01', '父'],
            ['1002', '関係', '020', '02', '母'],
            ['1002', '関係', '030', '03', '叔母'],
            ['1002', '関係', '040', '04', '叔父'],
            ['1002', '関係', '050', '05', '祖父'],
            ['1002', '関係', '060', '06', '祖母'],
            ['1002', '関係', '070', '07', 'その他'],
        ];
        if (0 === DB::table('code_masters')->count()) {
            foreach ($codeMasters as $code) {
                DB::table('code_masters')->insert([
                'group_code' => $code[0],
                'group_name' => $code[1],
                'display_order' => $code[2],
                'name' => $code[4],
                'code' => $code[3],
            ]);
            }
        }
    }
}
