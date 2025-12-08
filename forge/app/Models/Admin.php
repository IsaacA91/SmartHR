<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    public $timestamps = false;
    protected $guard = 'admin';
    protected $table = 'admin';
    protected $primaryKey = 'adminID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'adminID',
        'firstName',
        'lastName',
        'companyID',
        'password',
        'profilePhoto',
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        // Only hash if it's not already a bcrypt hash
        if (!str_starts_with($value, '$2y$') && !str_starts_with($value, '$2a$') && !str_starts_with($value, '$2b$')) {
            $this->attributes['password'] = bcrypt($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'companyID', 'companyID');
    }
}
