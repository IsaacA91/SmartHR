<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation;

class Employee extends Model
{
    protected $guard = 'employee';
    protected $table = 'employee';
    protected $primaryKey = 'employeeID';
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
