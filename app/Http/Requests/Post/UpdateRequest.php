<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name'=>'required|string|min:2',
            'content'=>'required|string|min:10',
            'images'=>'nullable|array',
            'images.*'=>'nullable|file',
            'category_id'=>'required|integer|exists:categories,id',
            'img'=>'nullable|json',
            'img_d'=>'nullable|json',
        ];
    }

    public function messages()
    {
        return parent::messages();
    }
}
