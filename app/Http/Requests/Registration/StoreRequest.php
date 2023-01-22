<?php

namespace App\Http\Requests\Registration;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'nik_name'=>'required|string|min:3',
            'email'=>'required|email|unique:App\Models\User,email',
            'country_id'=>'required|integer|exists:countries,id',
            'age'=>'required|date',
            'img'=>'required|file',
            'gender'=>'required|string',
        ];
    }
}
