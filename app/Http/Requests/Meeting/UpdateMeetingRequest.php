<?php

namespace App\Http\Requests\Meeting;

use App\Models\Meeting;

class UpdateMeetingRequest extends CreateMeetingRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $meeting = $this->route('meeting');

        return parent::authorize() && Meeting::STATUS_SENT !== $meeting->status;
    }
}
