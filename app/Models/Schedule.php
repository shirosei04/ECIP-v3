<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $primaryKey = 'sched_id';
    protected $table = 'schedules';
    public $timestamps = false;

    protected $fillable = [
        'sub_id',
        'semester',
        'days',
        'time_start',
        'time_end',
        'id',
        'sect_id',
        'year_id',
        'room_id',
    ];

    public function room(){
        return $this->hasOne(Room::class, 'room_id', 'room_id');
    }

    public function teacher(){
        return $this->hasOne(User::class, 'id', 'id');
    }

    public function section(){
        return $this->hasOne(Section::class, 'section_id', 'sect_id');
    }

    public function subject(){
        return $this->hasOne(Subject::class, 'subject_id', 'sub_id');
    }

    public function schoolYear(){
        return $this->hasOne(SchoolYear::class, 'sy_id', 'year_id');
    }


}
