<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    protected $primaryKey = 'announcement_id';
    protected $table = 'announcements';

    protected $fillable = [
        'id',
        'announcement_title',
        'announcement_content',
        'announcement_img',
        'posted_at'
    ];
}
