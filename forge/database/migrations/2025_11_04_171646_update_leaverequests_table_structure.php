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
        // Drop the existing table if it exists
        Schema::dropIfExists('leaverequests');

        // Create the table with the exact structure from the schema
        Schema::create('leaverequests', function (Blueprint $table) {
            $table->string('leaveRecordID', 5)->primary();
            $table->string('employeeID', 4);
            $table->date('startDate');
            $table->date('endDate');
            $table->enum('approval', ['Approved', 'Pending', 'Rejected'])->default('Pending');
            $table->string('approvedBy', 4)->nullable();
            
            $table->foreign('employeeID')
                  ->references('employeeID')
                  ->on('employee')
                  ->onDelete('cascade');
            
            // Optional: Add foreign key for approvedBy if needed
            // $table->foreign('approvedBy')
            //       ->references('adminID')
            //       ->on('admin')
            //       ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaverequests');
    }
};
