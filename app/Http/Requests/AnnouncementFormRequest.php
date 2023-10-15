<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementFormRequest extends FormRequest
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
            'id' => [

            ],
            'posted_at' => [

            ],
            'announcement_title' => [
                'required',
                'max: 70'
            ],
            'announcement_content' => [
                'max: 500'
            ]
        ];
    }

    // public function messages(){
    //     return [
    //         'announcement_content.max' => ['Nigga pls. Message is too long'],
            
    //     ];
    // }
}
