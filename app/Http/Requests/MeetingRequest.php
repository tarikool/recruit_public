<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingRequest extends FormRequest
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
        $modules = [ 1 => 'client', 2 => 'contact', 3 => 'job'];
        $table = strtolower( str_plural( $modules[request('related_module',1)]));

        return [
            'title' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'start_date_time' => 'nullable|date_format:Y-m-d H:i',
            'end_date_time' => 'nullable|date_format:Y-m-d H:i',
            'related_module' => 'nullable|required_with:related_module_id|integer|in:'.implode(',',array_keys($modules)),
            'related_module_id' => 'nullable|required_with:related_module|integer|exists:'.$table.',id',
            'description' => 'nullable|string',
            'reminder_date_time' => 'nullable|string',
            'status' => 'sometimes|required|integer|in:0,1',
        ];
    }
}
