<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequ extends FormRequest
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
            'title' => 'required|max:1000',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'ingredients' => 'nullable|array',
            'label' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'featured_image' => 'nullable|integer'
        ];
    }
}
