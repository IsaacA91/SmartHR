<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leaverequests', function (Blueprint $table) {
            // Drop and recreate columns with correct lengths
            $table->string('leaveRecordID', 10)->change();
            $table->string('employeeID', 10)->change();
            $table->date('start_date')->change();
            $table->date('startDate')->change();
            $table->date('end_date')->change();
            $table->date('endDate')->change();
            $table->text('reason')->change();
            $table->string('status', 20)->change();
            $table->string('approval', 20)->change();
            $table->text('admin_remarks')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leaverequests', function (Blueprint $table) {
            //
        });
    }
};
