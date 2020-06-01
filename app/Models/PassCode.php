<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class PassCode extends Model
{
    // use SoftDeletes;

    protected $table = 'passcodes';

    public function getActivePasscode($passcode)
    {
        return $this->where('passcode', $passcode)
            ->where('used', 0)
            ->first();
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id', 'id');
    }

    public static function generate(int $student_id)
    {
        $passcode = new self();
        $passcode->student_id = $student_id;
        $passcode->used = 0;
        $passcode->passcode = self::createPasscode();
        $passcode->save();

        return $passcode;
    }

    public static function createPasscode()
    {
        // 変数の初期化
        $res = null; //生成した文字列を格納
        $string_length = 7; //生成する文字列の長さを指定
        //$base_strings = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $base_strings = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 2, 3, 4, 5, 6, 7, 8, 9];

        for ($i = 0; $i < $string_length; ++$i) {
            $res .= $base_strings[mt_rand(0, count($base_strings) - 1)];
        }

        return $res;
    }
}
