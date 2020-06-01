<?php

namespace App\Http\Requests\Seminar;

use Illuminate\Foundation\Http\FormRequest;

class CreateSeminarRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $defaults = [
            'subject' => 'required',
            'body' => 'required',
            'scheduled_date' => [
                'required',
                'date_format:Y-m-d',
            ],
            'scheduled_time' => [
                'required',
                'date_format:H:i',
            ],
            'deadline_date' => [
                'required',
                'after:scheduled_date',
            ],
            'max_people' => ['required', 'numeric'],
            'enable_help' => 'present',
            'sender' => 'required',
            'seminar_for_school_classes' => 'required',
            'address' => 'required',
            'fee' => [
                'required',
                'numeric',
                'min:0',
            ],
            'tel' => [
                'required',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'min:0',
            ],
            'instructor' => [
                'required',
            ],
        ];
        if ('on' === $this->input('enable_help')) {
            $help_field_rules = [
                'reason' => 'required',
                'help_scheduled_date' => [
                    'required',
                    'date_format:Y-m-d',
                ],
                'help_scheduled_time' => [
                    'required',
                    'date_format:H:i',
                ],
                'help_deadline_date' => [
                    'required',
                    'date_format:Y-m-d',
                    'after:help_scheduled_date',
                ],
                'max_help_people' => [
                    'sometimes',
                    'required',
                ],
                'help_tel' => [
                    'required',
                    'regex:/^([0-9\s\-\+\(\)]*)$/',
                    'min:0',
                ],
            ];
        } else {
            $help_field_rules = [];
        }

        return array_merge($defaults, $help_field_rules);
    }
}
