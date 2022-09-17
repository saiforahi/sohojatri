<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required|string|between:2,100',
            'lname' => 'required|string|between:2,100',
            'email' => 'sometimes|nullable|string|email|max:100|unique:users,email',
            'bio' => 'sometimes|nullable|string',
            'dob'=> 'required|date|date_format:Y-m-d|before:today'
        ];
    }
}
