<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'department';
    protected $primaryKey = 'departmentID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'departmentID',
        'departmentName',
        'departmentManager',
        'departmentLocation',
        'companyID'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'companyID', 'companyID');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'departmentID', 'departmentID');
    }
}