<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstimateShippingRequest extends FormRequest
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
            'src' => 'required|exists:ports,id',
            'dst' => 'required|exists:ports,id|different:src'
        ];
    }

    public function messages()
    {
        return [
            'src.required' => 'Departure Port can not be empy',
            'dst.required' => 'Arrival Port can not be empy',

        ];
    }
}
