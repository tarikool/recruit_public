<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateRequest extends FormRequest
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
        $user_id = $this->candidate ? $this->candidate->user_id : null;
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|confirmed|min:6|max:30',
            'number' => 'required|string|min:9|max:15',
            'email' => 'required|email|unique:users,email,'.$user_id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fax' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
            'country_id' => 'nullable|integer|exists:countries,id',
            'total_year_of_experience' => 'nullable|numeric|min:0',
            'highest_qualification' => 'nullable|string|max:255',
            'expected_salary' => 'nullable|numeric|min:0',
            'skillset' => 'nullable|string',
            'additional_info' => 'nullable|string',
            'twitter_profile_url' => 'nullable|url|max:255',
            'skype_profile_url' => 'nullable|url|max:255',
            'candidate_source_id' => 'required|integer|exists:candidate_sources,id',
            'resume' => 'nullable|mimes:doc,docx,pdf|max:5120',
            'cover_letter' => 'nullable|mimes:doc,docx,pdf|max:5120',
            'contracts' => 'nullable|mimes:doc,docx,pdf|max:10240',
            'relocate_willing' => 'sometimes|required|integer|in:0,1',
            'status' => 'sometimes|required|integer|in:0,1',
        ];
    }



}
