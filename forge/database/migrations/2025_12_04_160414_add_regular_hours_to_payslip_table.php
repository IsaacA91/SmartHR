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
        Schema::table('payslip', function (Blueprint $table) {
            $table->decimal('regularHours', 5, 1)->nullable()->after('overtimeHours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payslip', function (Blueprint $table) {
            $table->dropColumn('regularHours');
        });
    }
};
