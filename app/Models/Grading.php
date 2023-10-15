<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grading extends Model
{
    use HasFactory;
    protected $primaryKey = 'grading_id';
    protected $table = 'gradings';
    public $timestamps = false;

    protected $fillable = [
        'grading',
        'status',
    ];
}
