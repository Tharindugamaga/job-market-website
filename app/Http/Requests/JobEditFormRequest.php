<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobEditFormRequest extends FormRequest
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
            'title' => 'required|min:5',
            'feature_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|min:10',
            'roles' => 'required',
            'job_type' => 'required',
            'address' => 'required',
            'date' => 'required',
            'salary' => 'required',
        ];
    }
}
