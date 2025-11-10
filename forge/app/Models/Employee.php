<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    protected $guard = 'employee';
    protected $table = 'employee';
    protected $primaryKey = 'employeeID';
    protected $keyType = 'string'; // If your employeeID is string
    public $incrementing = false; // If your employeeID is not auto-incrementing
    public $timestamps = false;

    protected $fillable = [
        'employeeID',
        'companyID',
        'position',
        'departmentID',
        'firstName',
        'lastName',
        'phone',
        'email',
        'username',
        'password',
        'baseSalary',
        'rate',
    ];

    protected $hidden = [
        'password',
    ];

    public function AttendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class, 'employeeID', 'employeeID');
    }
}
