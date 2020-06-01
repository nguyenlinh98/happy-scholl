<?php

namespace App\Http\Requests\ClassGroup;

use Illuminate\Foundation\Http\FormRequest;

class MassDeleteClassGroupRequest extends FormRequest
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
            'class_group_ids' => 'required',
        ];
    }
}
