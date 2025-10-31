<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $table = 'leaverequests';
    protected $primaryKey = 'leaveRecordID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'leaveRecordID',
        'employeeID',
        'startDate',
        'endDate',
        'approval',
        'approvedBy'
    ];

    protected $casts = [
        'startDate' => 'date',
        'endDate' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employeeID', 'employeeID');
    }

    public function approver()
    {
        return $this->belongsTo(Admin::class, 'approvedBy', 'adminID');
    }
}