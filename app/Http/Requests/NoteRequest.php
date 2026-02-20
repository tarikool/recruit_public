<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
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
        $modules = getNoteRelatedModules();
        $table = strtolower( str_plural( $modules[request('related_module',1)]));

        return [
            'related_module' => 'nullable|required_with:related_module_id|integer|in:'.implode(',',array_keys($modules)),
            'related_module_id' => 'nullable|required_with:related_module|integer|exists:'.$table.',id',
            'note_type_id' => 'required|integer|exists:note_types,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|integer|in:0,1',
        ];
    }
}
