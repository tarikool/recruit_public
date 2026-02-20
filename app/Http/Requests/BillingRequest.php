<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillingRequest extends FormRequest
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
            'issue_date' => 'nullable|date',
            'invoice_code' => 'required|string|max:255|unique:billings,invoice_code,'.$this->invoice_code,
            'client_id' => 'required|integer|exists:clients,id',
            'is_notified' => 'nullable|integer|in:0,1',
            'sub_total_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'nullable|numeric|min:0',
            'jobDetails.jobs.*.id' => 'required|integer|exists:jobs,id',
            'jobDetails.jobs.*.amount' => 'required|numeric|min:0',
            'jobDetails.jobs.*.discount' => 'required|numeric|min:0',
            'jobDetails.jobs.*.remarks' => 'nullable',
            'jobDetails.jobs.*.total' => 'required|numeric|min:0',
            'jobDetails.tax_amount' => 'nullable|numeric|min:0',
            'jobDetails.due_amount' => 'nullable|numeric|min:0',
        ];
    }
}
