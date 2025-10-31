<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaySlip extends Model
{
    protected $table = 'payslip';
    protected $primaryKey = 'slipID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'slipID',
        'employeeID',
        'payPeriodBeginning',
        'payPeriodEnd',
        'overtimeHours',
        'totalPayForPeriod'
    ];

    protected $casts = [
        'payPeriodBeginning' => 'date',
        'payPeriodEnd' => 'date',
        'overtimeHours' => 'decimal:1',
        'totalPayForPeriod' => 'decimal:2'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employeeID', 'employeeID');
    }
}