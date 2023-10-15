<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleFormRequest extends FormRequest
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
            'sub_id' => [

            ],
            'semester' => [
                
            ],
            'days' => [
                'required',
            ],
            'time_start' => [
                
            ],
            'time_end' => [
                
            ],
            'id' => [
                
            ],
            'sect_id' => [
                
            ],
            'year_id' => [
                
            ],
            'room_id' => [
                
            ],
        ];
    }
}
