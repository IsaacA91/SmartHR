<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    protected $table = 'attendancerecord';
    protected $primaryKey = 'recordID';
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
        return $this->belongsTo(Employee::clas, 'employeeID', 'employeeID');
    }
}
