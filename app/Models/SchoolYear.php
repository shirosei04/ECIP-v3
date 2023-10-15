<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    use HasFactory;
    protected $primaryKey = 'sy_id';
    protected $table = 'school_years';
    public $timestamps = false;
    
    protected $fillable = [
        'school_year',
        'type',
        'is_current',
        'enrollment',
    ];
}
