<?php

namespace App\Http\Requests;

use App\Models\UrgentContact;
use Illuminate\Foundation\Http\FormRequest;

class CreateUrgentContact extends FormRequest
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
            'subject' => 'required|string|max:255',
            'sender' => 'required|string|max:255',
            'in_questions' => 'required|array|min:1',
            'yn_questions' => 'required|array|min:1',
            'school_classes' => 'array|required|min:1',
        ];
    }

    protected function prepareForValidation()
    {
        $this->normalizeRequestInput();
    }

    protected function normalizeRequestInput()
    {
        // Get default yesno and input question from the model.
        $urgentContact = UrgentContact::getInstanceWithQuestions();

        $polarQuestions = $urgentContact->general_questions;

        $whQuestions = $urgentContact->special_questions;

        $yesNoQuestions = $this->composeYesNoQuestions($polarQuestions);

        $inputQuestions = $this->composeInputQuestions($whQuestions);

        $input = $this->input();

        $input['yn_questions'] = $yesNoQuestions->toArray();

        $input['in_questions'] = $inputQuestions->toArray();

        $this->replace($input);
    }

    protected function composeYesNoQuestions($polarQuestions)
    {
        return collect($yesNoQuestionTexts = $this->input('yn_questions'))->filter(function($value, $key) {
            // Only remains input relating to the questionnaire and not null.
            return  preg_match('/^(YN|IN)[0-9]+$/', $key) && ! is_null($value) ;
        })->map(function($value, $key) use ($yesNoQuestionTexts, $polarQuestions) {
            // Render default questions
            if(1 === preg_match('/^YN([1-6]+)$/', $key, $matches)) {
                return $polarQuestions[$matches[0]];
            };
            // Render custom questions
            if(1 === preg_match('/^YN([7-9]+|10)$/', $key, $matches)) {
                return $yesNoQuestionTexts["{$matches[0]}_text"];
            };

            return $value;
        })->reject(function($value, $key) {
            return is_null($value);
        });
    }

    protected function composeInputQuestions($whQuestions)
    {
        return collect($inputQuestionTexts = $this->input('in_questions'))->filter(function($value, $key) {
            // Only remains input relating to the questionnaire. and not null
            return  preg_match('/^(YN|IN)[0-9]+$/', $key) && ! is_null($value) ;
        })->map(function($value, $key) use ($inputQuestionTexts, $whQuestions) {
            // Render default questions
            if(1 === preg_match('/^IN([1-3]+)$/', $key, $matches)) {
                return $whQuestions[$matches[0]];
            };

            // Render custom questions
            if(1 === preg_match('/^IN([4-7]+)$/', $key, $matches)) {
                return $inputQuestionTexts["{$matches[0]}_text"];
            };

            return $value;
        })->reject(function($value, $key) {
            return is_null($value);
        });
    }
}
