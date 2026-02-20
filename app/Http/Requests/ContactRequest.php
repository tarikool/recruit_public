<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        $id = $this->contact ? $this->contact->id : null;

        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'client_id' => 'required|integer|exists:clients,id',
            'email' => 'required|email|unique:contacts,email,'.$id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fax' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:15',
            'job_title' => 'nullable|string|max:255',
            'twitter_profile_url' => 'nullable|url|max:255',
            'linkedin_profile_url' => 'nullable|url|max:255',
            'billing_street' => 'required|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_code' => 'required|string|max:255',
            'billing_country_id' => 'required|integer|exists:countries,id',
            'shipping_street' => 'nullable|string|max:255',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_code' => 'nullable|string|max:255',
            'shipping_country_id' => 'nullable|integer|exists:countries,id',
            'client_source_id' => 'required|integer|exists:client_sources,id',
            'attached_others' => 'nullable|mimes:doc,docx,pdf|max:5120',
            'status' => 'sometimes|required|integer|in:0,1',
        ];
    }
}
