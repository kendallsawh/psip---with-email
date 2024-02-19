<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\PsipName;
use App\Models\Division;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'divisions_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Always encrypt password when it is updated.
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function createdByDocTypeDivisions()
    {
        return $this->hasMany('App\Models\DocTypeDivision', 'created_by', 'id');
    }

    public function createdByPsipDocs()
    {
        return $this->hasMany('App\Models\PsipDoc', 'created_by', 'id');
    }

    public function createdByPsipNames()
    {
        return $this->hasMany('App\Models\PsipName', 'created_by', 'id');
    }

    /**
     * Get all PsipName records that belong to the same division.
     */
    public function psipNames()
    {
        return $this->hasManyThrough(
            PsipName::class, // The target model you want to access
            Division::class, // The intermediate model (if you have one, assuming Division is a model that represents the divisions)
            'id', // Foreign key on the Division table
            'division_id', // Foreign key on the PsipName table
            'divisions_id', // Local key on the User table
            'id' // Local key on the Division table (if Division is a model, otherwise adjust accordingly)
        );
    }

}