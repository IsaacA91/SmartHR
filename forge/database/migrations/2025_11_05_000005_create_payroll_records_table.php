<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payroll_records', function (Blueprint $table) {
            $table->string('recordID', 10)->primary();
            $table->string('employeeID', 4)->collation('utf8mb4_unicode_ci');
            $table->date('payPeriodStart');
            $table->date('payPeriodEnd');
            $table->decimal('regularHours', 8, 2);
            $table->decimal('overtimeHours', 8, 2)->default(0);
            $table->decimal('regularPay', 10, 2);
            $table->decimal('overtimePay', 10, 2)->default(0);
            $table->decimal('totalPay', 10, 2);
            $table->decimal('deductions', 10, 2);
            $table->decimal('netPay', 10, 2);
            $table->string('status', 20)->default('pending'); // pending, processed, paid
            
            $table->foreign('employeeID')
                  ->references('employeeID')
                  ->on('employee')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payroll_records');
    }
};