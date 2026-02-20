<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
        $id = $this->job ? $this->job->id : null;
        return [
            'job_title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:jobs,slug,'.$id,
            'number_of_opening' => 'required|integer|min:1',
            'client_id' => 'required|integer|exists:clients,id',
            'contact_id' => 'required|integer|exists:contacts,id',
            'publish_date' => 'required|date',
            'last_apply_date' => 'nullable|date|gte:publish_date',
            'industry_id' => 'nullable|integer|exists:industries,id',
            'job_type_id' => 'nullable|integer|exists:job_types,id',
            'job_opening_status_id' => 'nullable|integer|exists:job_opening_statuses,id',
            'min_experience' => 'nullable|integer|min:0',
            'max_experience' => 'nullable|integer|min:0',
            'min_salary' => 'nullable|regex:/^\+?[0-9]+(\.\d{1,3})?$/',
            'max_salary' => 'nullable|regex:/^\+?[0-9]+(\.\d{1,3})?$/',
            'currency_id' => 'nullable|integer|exists:currencies,id',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
            'country_id' => 'nullable|integer|exists:countries,id',
            'roles_responsibility' => 'nullable|string',
            'requirement' => 'nullable|string',
            'additional_requirement' => 'nullable|string',
            'benefit' => 'nullable|string',
            'related_file' => 'nullable|mimes:doc,docx,pdf|max:5120',
            'status' => 'sometimes|required|integer|in:0,1'
        ];
    }












}
