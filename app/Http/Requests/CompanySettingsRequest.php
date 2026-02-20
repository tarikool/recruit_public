<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanySettingsRequest extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|string|max:255',
            'company_phone' => 'required|string|max:255',
            'address' => 'required|string',
            'website' => 'required|url|max:255',
            'timezone' => 'required|string|max:255',
            'locale_language' => 'required|string|max:255',
            'latitude' => 'required|regex:/^\+?[0-9]+(\.\d{1,})?$/|max:10',
            'longitude' => 'required|regex:/^\+?[0-9]+(\.\d{1,})?$/|max:11',
            'logo' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'status' => 'sometimes|required|integer|in:0,1',
        ];
    }
}
