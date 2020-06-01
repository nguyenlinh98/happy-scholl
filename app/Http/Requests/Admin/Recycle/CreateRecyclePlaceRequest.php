<?php

namespace App\Http\Requests\Admin\Recycle;

use App\Models\RecyclePlace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRecyclePlaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'recycle_place_name' => 'required',
            'recycle_place_date' => [
                'required',
            ],
            'recycle_place_start_time' => [
                'required',
            ],
            'recycle_place_end_time' => [
                'required',
                'after:recycle_place_start_time',
            ],
        ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'recycle_place_end_time.after' => '開始時間より後の日時を指定してください。',
        ];
    }
}
