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
    ];
    public function getAuthIdentifierName()
    {
        return 'adminID';
    }
    protected $hidden = [
        'password',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class, 'companyID');
    }

}