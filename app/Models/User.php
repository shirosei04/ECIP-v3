<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'is_verified',
        'date_of_registration',
        'sex',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'birth_date',
        'birth_place',
        'region',
        'province',
        'city',
        'barangay',
        'house_no',
        'nationality',
        'religion',
        'ethnicity',
        'mother_tongue',
        'cell_no',
        'tel_no',
        'email',
        'fb_acc',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //get student detail 
    public function student(){
        return $this->hasOne(StudentDetail::class, 'id');
    }

    public function parents(){
        return $this->hasMany(ParentGuardian::class, 'id');
    }
}
