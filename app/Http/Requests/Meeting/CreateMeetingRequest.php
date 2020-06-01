<?php

namespace App\Http\Requests\Meeting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CreateMeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isSchoolAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $params = $request->all();
        $rules = [
            'subject' => 'required',
            'file' => 'sometimes|file|mimes:pdf,jpg,png',
            'sender' => 'required',
            'contact_email' => [
                'required',
                'email',
            ],
            'zoom_link' => 'required',
            'send_to_select' => 'required_without:individual_receivers',
            'send_to_school_classes' => [
                'required_if:send_to_select,school_classes',
                // 'exists:school_classes,id',
            ],
            'send_to_departments' => [
                'required_if:send_to_select,departments',
                // 'exists:departments,id',
            ],
            'send_to_class_groups' => [
                'required_if:send_to_select,class_groups',
                // 'exists:class_groups,id',
            ],
            'individual_receivers' => [
                'required_without:send_to_select',
            ],
            'scheduled_datetime' => 'after:"now"',
        ];
        if (2 == $request->get('checkDateSetting')) {
            $rules += [
                'date' => 'required',
                'time' => 'required',
            ];
        }

        return  $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'scheduled_datetime' => $this->get('date').' '.$this->get('time'),
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
            'send_to_school_classes.required_if' => 'クラスは必須項目です',
            'send_to_departments.required_if' => '所属先は必須項目です',
            'send_to_class_groups.required_if' => 'クラスグループは必須項目です',
            'individual_receivers.required_without' => '必須項目です',
            'scheduled_datetime.after' => '現在より後の日時を指定してください。',
        ];
    }
}
