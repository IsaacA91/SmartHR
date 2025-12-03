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
        Schema::table('sessions', function (Blueprint $table) {
            // First drop the existing column
            $table->dropColumn('user_id');
            
            // Then recreate it as string
            $table->string('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            // First drop the string column
            $table->dropColumn('user_id');
            
            // Then recreate it as unsigned big integer
            $table->unsignedBigInteger('user_id')->nullable();
        });
    }
};