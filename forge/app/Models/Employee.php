<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';
    protected $primaryKey = 'employeeID';
    public $incrementing = false; 
    protected $keyType = 'string';
    protected $fillable = [
        'employeeID',
        'company',
        'position',
        'department',
        'firstName',
        'lastName',
        'phone',
        'email',
        'username',
        'password',
        'baseSalary',
        'rate'
    ];

    protected $hidden = [
        'password'
    ];
}
