<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'detail_id';
    protected $table = 'student_details';

    protected $fillable = [
        'id',
        'lrn',
        'track',
        'past_school',
        'past_school_address',
        'past_school_id',
        'has_comorbidity',
        'illnesses',
        'vaccine_status',
        'grade_lvl',
        'hgfrl',
        'mogts',
        'is_madrasah_enrolled',
        'is_4ps_member',
        'enrollment_status',
    ];

   
}
