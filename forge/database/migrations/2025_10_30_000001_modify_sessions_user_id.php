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
        // Get the list of all foreign keys
        $connection = Schema::getConnection();
        $table = 'sessions';
        
        // Use raw SQL to drop any foreign keys on user_id column
        try {
            $connection->statement("ALTER TABLE {$table} DROP FOREIGN KEY sessions_user_id_foreign");
        } catch (\Exception $e) {
            // FK might not exist
        }
        
        Schema::table('sessions', function (Blueprint $table) {
            // Check if column exists before modifying
            if (Schema::hasColumn('sessions', 'user_id')) {
                $table->dropColumn('user_id');
            }
            
            // Add as string column
            $table->string('user_id', 255)->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Try to drop the column if it exists
        if (Schema::hasTable('sessions') && Schema::hasColumn('sessions', 'user_id')) {
            Schema::table('sessions', function (Blueprint $table) {
                $table->dropColumn('user_id');
            });
        }
    }
};