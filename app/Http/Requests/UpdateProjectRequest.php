<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:100',
            'type_id' => 'required|exists:types,id',
            'github_reference' => 'required|url|max:255',
            'description' => 'required|string|max:65535'
        ];
    }

    public function messages(){
        return [
            'title.required' => 'Title is required',
            'title.unique' => 'Title selected is already used',
            'title.string' => 'Title must to be a string',
            'title.max' => 'Too long title',

            'type_id.required' => 'Type is required',
            'type_id.exists' => 'Type not available',
            
            'github_reference.required' => 'Github Link is required',
            'github_reference.unique' => 'Github Link selected is already used',
            'github_reference.url' => 'Github Link must to be a URL',
            'github_reference.max' => 'Too long link',

            'description.required' => 'Description is required',
            'description.string' => 'Description must to be a string',
            'description.max' => 'Too long description',
        ];
    }
}
