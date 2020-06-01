<?php

namespace App\Http\Requests\RequireFeedback;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CreateRequireFeedbackRequest extends FormRequest
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
        $rules = [
            'body' => 'required',
            'subject' => 'required',
            'sender' => 'required',
            'deadline_date' => [
                'required',
                'date',
                'after:now',
            ],
            'clean_up_date' => [
                'required',
                'date',
                'after:now',
            ],
            'confirmation' => 'required',
            'required_feedback_for_school_classes' => 'required',
            'scheduled_datetime' => 'after:"now"',
        ];
        if  ($request->get('checkDateSetting') == 2) {
            $rules += [
                'scheduled_date' => [
                    'required',
                    'date_format:Y-m-d',
                ],
                'scheduled_time' => 'required',
                'deadline_date' => [
                    'required',
                    'date',
                    'after:scheduled_date',
                ],
                'clean_up_date' => [
                    'required',
                    'date',
                    'after:scheduled_date',
                ],
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
            'deadline_date.after' => '通知日時設定より後の日付を指定してください。',
            'clean_up_date.after' => '締切日設定より後の日付を指定してください。',
            'scheduled_datetime.after' => '現在より後の日時を指定してください。',
        ];
    }
}
