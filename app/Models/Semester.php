<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $primaryKey = 'sem_id';
    protected $table = 'semesters';
    public $timestamps = false;
    
    protected $fillable = [
        'sem_status'
    ];
}
