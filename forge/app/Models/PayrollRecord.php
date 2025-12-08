<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollRecord extends Model
{
    protected $table = 'payroll_records';
    protected $primaryKey = 'recordID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'recordID',
        'employeeID',
        'payPeriodStart',
        'payPeriodEnd',
        'regularHours',
        'overtimeHours',
        'regularPay',
        'overtimePay',
        'totalPay',
        'deductions',
        'netPay',
        'status'
    ];

    protected $casts = [
        'payPeriodStart' => 'date',
        'payPeriodEnd' => 'date',
        'regularHours' => 'decimal:2',
        'overtimeHours' => 'decimal:2',
        'regularPay' => 'decimal:2',
        'overtimePay' => 'decimal:2',
        'totalPay' => 'decimal:2',
        'deductions' => 'decimal:2',
        'netPay' => 'decimal:2'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employeeID', 'employeeID');
    }

    public function calculatePay()
    {
        $this->regularPay = $this->regularHours * $this->employee->rate;
        $this->overtimePay = $this->overtimeHours * ($this->employee->rate * 1.5);  // Overtime is 1.5x regular rate
        $this->totalPay = $this->regularPay + $this->overtimePay;
        $this->deductions = $this->totalPay * 0.12;  // Example: 12% for taxes and deductions
        $this->netPay = $this->totalPay - $this->deductions;
    }
}
