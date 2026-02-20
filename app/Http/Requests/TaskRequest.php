<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date_format:Y-m-d G:i',
            'client_id' => 'nullable|integer|exists:clients,id',
            'contact_id' => 'nullable|integer|exists:contacts,id',
            'task_status_id' => 'required|integer|exists:task_statuses,id',
            'priority' => 'nullable|integer|in:1,2,3,4,5',
            'status' => 'sometimes|required|integer|in:0,1',
        ];
    }
}
