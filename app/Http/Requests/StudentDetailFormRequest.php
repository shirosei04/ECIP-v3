<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentDetailFormRequest extends FormRequest
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
            'user_id' => [

            ],
            'lrn' => [
                
            ],
            'grade_lvl' => [

            ],
            'hgfrl' => [

            ],
            'past_school' => [

            ],
            'past_school_add' => [

            ],
            'past_school_id' => [

            ],
            'has_comorbidity' => [

            ],
            'illnesses' => [

            ],
            'vaccine_status' => [

            ],
            'mogts' => [

            ],
            'is_4ps' => [

            ],
            'is_madrasah_enrolled' => [

            ],
            'fname' => [

            ],
            'mname' => [

            ],
            'lname' => [

            ],
            'suffix' => [

            ],
            'relationship' => [

            ],
            'occupation' => [

            ],
            'contact_no' => [

            ],
            'email' => [

            ],
            'fb_acc' => [

            ],
            
        ];
    }
}
