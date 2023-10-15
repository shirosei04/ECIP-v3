<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $primaryKey = 'subject_id';
    protected $table = 'subjects';
    public $timestamps = false;
    
    protected $fillable = [
        'subject_name',
        'curriculumId',
        'subject_grade_lvl',
        'track'
    ];

}
