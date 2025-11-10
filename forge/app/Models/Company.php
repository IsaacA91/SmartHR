<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $timestamps = false;
    protected $table = 'company';
    protected $primaryKey = 'companyID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'companyID',
        'companyName',
        'companyOwner'
    ];

    public function departments()
    {
        return $this->hasMany(Department::class, 'companyID', 'companyID');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'companyID', 'companyID');
    }

    public function admins()
    {
        return $this->hasMany(Admin::class, 'companyID', 'companyID');
    }
}
