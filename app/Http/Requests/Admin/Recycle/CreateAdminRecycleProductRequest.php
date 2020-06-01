<?php

namespace App\Http\Requests\Admin\Recycle;

use App\Models\RecycleProduct;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateAdminRecycleProductRequest extends FormRequest
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
    public function rules()
    {
        return [
            'product_status' => [
                'required',
                Rule::in((new RecycleProduct())->getPredefinedConstants('PRODUCT_STATUS')),
            ],
            'name' => 'required',
        ];
    }
}
