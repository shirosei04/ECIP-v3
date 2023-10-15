<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentGuardian extends Model
{
    use HasFactory;
    protected $primaryKey = 'pg_id';
    protected $table = 'parent_guardians';

    protected $fillable = [
        'id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'relationship',
        'occupation',
        'contact_no',
        'email',
        'fb_account',
    ];
}
