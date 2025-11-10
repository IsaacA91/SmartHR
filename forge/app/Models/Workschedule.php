<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    protected $table = 'workschedule';
    protected $primaryKey = 'scheduleID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'scheduleID',
        'employeeID',
        'shiftDate',
        'shiftBegin',
        'shiftEnd'
    ];

    protected $casts = [
        'shiftDate' => 'date',
        'shiftBegin' => 'datetime',
        'shiftEnd' => 'datetime'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employeeID', 'employeeID');
    }
}
