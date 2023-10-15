<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $primaryKey = 'section_id';
    protected $table = 'sections';
    public $timestamps = false;
    
    protected $fillable = [
        'section_grade_lvl',
        'section_name',
        'capacity',
    ];
}
