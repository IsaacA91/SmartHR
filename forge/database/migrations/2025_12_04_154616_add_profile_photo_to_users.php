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
        Schema::table('employee', function (Blueprint $table) {
            $table->string('profilePhoto')->nullable()->after('password');
        });

        Schema::table('admin', function (Blueprint $table) {
            $table->string('profilePhoto')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->dropColumn('profilePhoto');
        });

        Schema::table('admin', function (Blueprint $table) {
            $table->dropColumn('profilePhoto');
        });
    }
};
