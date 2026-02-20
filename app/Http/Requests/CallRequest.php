<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CallRequest extends FormRequest
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
            'topic' => 'required|string|max:255',
            'call_type' => 'required|integer|in:0,1',
            'call_purpose_id' => 'required|integer|exists:call_purposes,id',
            'client_id' => 'required_without:contact_id|nullable|integer|exists:clients,id',
            'contact_id' => 'required_without:client_id|nullable|integer|exists:contacts,id',
            'start_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:G:i',
            'notes' => 'nullable|string',
            'status' => 'sometimes|required|in:0,1',
        ];
    }
}
