<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leaverequests', function (Blueprint $table) {
            $table->string('leaveRecordID', 10)->primary();
            $table->string('employeeID', 10);
            $table->date('start_date');
            $table->date('startDate');
            $table->date('end_date');
            $table->date('endDate');
            $table->text('reason');
            $table->string('status', 20);
            $table->string('approval', 20);
            $table->text('admin_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
