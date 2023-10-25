<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegistrationFormRequest extends FormRequest
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
            'sex' => [
               'required',
            ],
            'role' => [

            ],
            'first_name' => [
               'required',
               'max: 50',
            ],
            'middle_name' => [
               'required',
               'max: 50',
            ],
            'last_name' => [
               'required',
               'max: 50',
            ],
            'suffix' => [
               'max: 10',
            ],
            'region' => [
               'required',
            ],
            'province' => [
               'required',
            ],
            'city' => [
               'required',
            ],
            'barangay' => [
               'required',
            ],
            'street' => [
               'required',
            ],
            'bdate' => [
               'required',   
            ],
            'bplace' => [
               'required',
            ],
            'nationality' => [
               'required',
            ],
            'religion' => [
               'required',
            ],
            'ethnicity' => [
               'required',
            ],
            'mother_tongue' => [
               'required',
            ],
            'tel_no' => [
               'numeric',
               'nullable',
 
            ],
            'cell_no' => [
               'numeric',
               'nullable',

            ],
            'email' => [
               'email:rfc,dns',
              'max: 60',
              'unique:users'
            ],
            'fb_acc' => [
              'max: 60', 
            ],
            'username' => [
              'required',
            ],
            'password' => [
              'confirmed',
              'required'
            ],
        ];
    }

 public function messages(){
     return [
      //   'password.confirmed' => ['Password must match.'],
        'tel_no.numeric' => ['The telephone number must be a number.'],
        'cell_no.numeric' => ['The cellphone number must be a number.'],
         'bplace.required' => ['The birth place field is required.'],
         'bdate.required' => ['The birth date field is required.'],
      ];
   }
}