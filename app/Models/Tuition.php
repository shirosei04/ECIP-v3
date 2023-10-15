<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuition extends Model
{
    use HasFactory;
    protected $primaryKey = 'tf_id';
    protected $table = 'tuition_fees';

    protected $fillable = [
        'for_grade_lvl',
        'tuition_fee',
        'misc_fee'
    ];
}
