<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $primaryKey = 'sg_id';
    protected $table = 'student_grades';
    public $timestamps = false;

    protected $fillable = [
        'stud_id',
        'schedule_id',
        'frst_grade',
        'scnd_grade',
        'thrd_grade',
        'frth_grade'
    ];

    public function schedule(){
        return $this->hasOne(Schedule::class, 'sched_id', 'schedule_id');
    }
}
