<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;
    protected $primaryKey = 'audit_id';
    protected $table = 'audits';

    protected $fillable = [
        'transaction_id',
        'transaction_description',
        'transaction_amount',
        'transaction_date',
        'transaction_type',
    ];
}
