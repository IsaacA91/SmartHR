<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class AttendanceRecord extends Model
{
    protected $table = 'attendancerecord';
    protected $primaryKey = 'recordID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'recordID',
        'employeeID',
        'workDay',
        'hoursWorked',
        'timeIn',
        'timeOut',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employeeID', 'employeeID');
    }
}
