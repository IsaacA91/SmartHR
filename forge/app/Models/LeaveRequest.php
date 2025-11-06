<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    // Table uses custom primary key and does not have Laravel timestamps columns
    protected $primaryKey = 'leaveRecordID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    // Use the actual table name in your database. Your MySQL table is named `leaverequests`.
    // Set the model to use that table so Eloquent can insert/read records correctly.
    protected $table = 'leaverequests';

    protected $fillable = [
        'leaveRecordID',
        'employeeID',
        'startDate',
        'endDate',
        'approval',
        'approvedBy'
    ];

    protected $dates = ['startDate', 'endDate'];

    protected $attributes = [
        'approval' => 'Pending',
        'startDate' => null,
        'endDate' => null
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employeeID', 'employeeID');
    }

    public function getTotalDaysAttribute()
    {
        if (!$this->startDate || !$this->endDate) {
            return 0;
        }

        return $this->startDate->diffInDays($this->endDate) + 1;
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['startDate'] = $value;
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['endDate'] = $value;
    }

    public function getStartDateAttribute($value)
    {
        return $this->asDate($value);
    }

    public function getEndDateAttribute($value)
    {
        return $this->asDate($value);
    }
}
