<?php

namespace App\Http\Requests\Event;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    // trick to redirect to create page for more details
    protected $redirectRoute = 'admin.event.create';

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
            'action' => 'sometimes|required|not_in:continue', // trick to redirect to create page for more details
            'title' => 'required',
            'start_time' => 'bail|required_unless:all_day,on',
            'end_time' => 'bail|required_unless:all_day,on',
            'start_date' => 'bail|required_without:single_date',
            'end_date' => 'bail|required_without:single_date',
            'single_date' => 'required_without_all:start_date,end_date',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->hasAny(['start_date', 'start_time', 'end_date', 'end_time'])) {
                return false;
            }
            if (!$this->validateStartAndEndDate()) {
                $validator->errors()->add('start_date_time', __('event.form.error.end_date_less_than_start_date'));
            }
        });
    }

    private function validateStartAndEndDate()
    {
        if ($this->has('single_date')) {
            if ('on' === $this->input('all_day')) {
                // skip checking for single date and all day
                return true;
            }

            return strtotime($this->start_time) < strtotime($this->end_time);
        }
        if ('on' !== $this->all_day) {
            $start_at = Carbon::createFromFormat('Y年m月d日 H:i', "{$this->start_date} {$this->start_time}");
            $end_at = Carbon::createFromFormat('Y年m月d日 H:i', "{$this->end_date} {$this->end_time}");
        } else {
            $start_at = Carbon::createFromFormat('Y年m月d日', $this->start_date);
            $end_at = Carbon::createFromFormat('Y年m月d日', $this->end_date);
        }

        hsp_debug($start_at->toString(), $end_at->toString());

        return $start_at->lessThan($end_at);
    }
}
