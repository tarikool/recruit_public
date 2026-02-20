<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'number' => 'required|string |max:15',
            'fax' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'industry_id' => 'required|integer|exists:industries,id',
            'about' => 'nullable|string',
            'image' => 'nullable|string',
            'client_source_id' => 'required|integer|exists:client_sources,id',
            'billing_street' => 'required|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_code' => 'required|string|max:255',
            'billing_country_id' => 'required|integer|exists:countries,id',
            'shipping_street' => 'nullable|string|max:255',
            'shipping_city' => 'nullable|string|max:255',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_code' => 'nullable|string|max:255',
            'shipping_country_id' => 'nullable|integer|exists:countries,id',
            'attached_contract' => 'nullable|mimes:doc,docx,pdf|max:5120',
            'attached_others' => 'nullable|mimes:doc,docx,pdf|max:5120',
            'status' => 'sometimes|required|integer|in:0,1',
        ];
    }
}
