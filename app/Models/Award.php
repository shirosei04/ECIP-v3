<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;
    protected $primaryKey = 'award_id';
    protected $table = 'awards';

    protected $fillable = [
        'award_name',
        'award_desc'
    ];
    
}
