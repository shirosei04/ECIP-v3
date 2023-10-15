<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyFormRequest extends FormRequest
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
            'school_year' => [
                'required',
            ],
            'type' => [
                'required',
            ],
            'is_current' => [

            ]
        ];
    }
}
