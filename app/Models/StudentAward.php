<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAward extends Model
{
    use HasFactory;
    protected $primaryKey = 'sa_id';
    protected $table = 'student_awards';

    protected $fillable = [
        'id',
        'awardId',
        'grade_lvl',
        'date_awarded',
    ];
 
}


