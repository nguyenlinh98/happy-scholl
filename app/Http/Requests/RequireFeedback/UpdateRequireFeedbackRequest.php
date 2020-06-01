<?php

namespace App\Http\Requests\RequireFeedback;

class UpdateRequireFeedbackRequest extends CreateRequireFeedbackRequest
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
}
