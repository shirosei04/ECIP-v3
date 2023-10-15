<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adviser extends Model
{
    use HasFactory;
    protected $primaryKey = 'adviser_id';
    protected $table = 'advisers';
    public $timestamps = false;
    
    protected $fillable = [
        'teacher_id',
        'tyear_id',
        'tsection_id',
    ];
}
