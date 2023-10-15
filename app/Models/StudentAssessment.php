<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAssessment extends Model
{
    use HasFactory;
    protected $primaryKey = 'studfee_id';
    protected $table = 'student_fees';

    protected $fillable = [
        'student_id',
        'year_id',
        'payment_desc',
        'payment_amount',
        'payment_type',
        'payment_date',
        'running_balance'
    ];

    public function student(){
        return $this->hasOne(User::class, 'id');
    }

    public function fee(){
        return $this->hasOne(Tuition::class, 'tf_id');
    }

    public function year(){
        return $this->hasOne(SchoolYear::class, 'sy_id', 'year_id');
    }

    public function audits(){
        return $this->hasMany(Audit::class, 'transaction_id', 'studfee_id');
    }
}
