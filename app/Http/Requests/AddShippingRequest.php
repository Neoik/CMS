<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AddShippingRequest extends FormRequest
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
            'dst' => 'required|exists:ports,id|different:src',
            'weight' => 'required|integer',
            'description' => 'max:255',
            'date' => 'required|date',
        ];
    }
}
