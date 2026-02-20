<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecruitmentQuestionRequest extends FormRequest
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
            'question_competency_id' => 'required|integer|exists:question_competencies,id',
            'question' => 'required|string',
            'difficulty' => 'required|integer|min:1|max:5',
            'answer' => 'nullable|string',
            'status' => 'sometimes|required|integer|in:0,1',
        ];
    }
}
