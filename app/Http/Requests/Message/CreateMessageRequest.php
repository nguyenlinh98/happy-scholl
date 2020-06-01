<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CreateMessageRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $params = $request->all();
        $rules = array(
            'subject' => 'required',
            'sender' => 'required',
            'message_send_to_school_classes' => 'required',
            'scheduled_datetime' => 'after:"now"',
        );
        if  ($request->get('checkDateSetting') == 2) {
            $rules += [
                'scheduled_date' => 'required',
                'scheduled_time' => 'required',
            ];
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'scheduled_datetime' => $this->get('scheduled_date').' '.$this->get('scheduled_time'),

        ]);
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'scheduled_datetime.after' => '現在より後の日時を指定してください。',
        ];
    }
}
