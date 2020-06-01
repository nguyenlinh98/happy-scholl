<?php

namespace App\Http\Requests\Letter;

use App\Models\Letter;

class UpdateLetterRequest extends CreateLetterRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $letter = $this->route('letter');

        return parent::authorize() && Letter::STATUS_SENT !== $letter->status;
    }
}
