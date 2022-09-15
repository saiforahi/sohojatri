<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class AddCarRequest extends FormRequest
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
            'brand' => 'required|max:15',
            'model' => 'required|max:191',
            'fuel' => 'required',
            'car_image1' => 'required',
            'car_image2' => 'required',
            'kilometers' => 'required',
            'regYear' => 'required',
            'modelYear' => 'required',
            'car_number' => 'required|unique:cars,number_plate',
        ];
    }
}
