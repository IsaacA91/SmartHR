<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, get the foreign key constraints
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME, TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE REFERENCED_TABLE_SCHEMA = DATABASE()
            AND REFERENCED_TABLE_NAME = 'employee'
            AND REFERENCED_COLUMN_NAME = 'employeeID'
        ");

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Drop foreign keys that reference employeeID
        foreach ($foreignKeys as $fk) {
            DB::statement("ALTER TABLE {$fk->TABLE_NAME} DROP FOREIGN KEY {$fk->CONSTRAINT_NAME}");
        }

        // Fix collation for employee table
        DB::statement('ALTER TABLE employee MODIFY employeeID VARCHAR(10) COLLATE utf8mb4_unicode_ci');
        DB::statement('ALTER TABLE employee MODIFY companyID VARCHAR(10) COLLATE utf8mb4_unicode_ci');
        
        // Fix collation for leaverequests table
        DB::statement('ALTER TABLE leaverequests MODIFY employeeID VARCHAR(10) COLLATE utf8mb4_unicode_ci');
        DB::statement('ALTER TABLE leaverequests MODIFY status VARCHAR(20) COLLATE utf8mb4_unicode_ci');
        DB::statement('ALTER TABLE leaverequests MODIFY approval VARCHAR(20) COLLATE utf8mb4_unicode_ci');

        // Recreate foreign keys
        foreach ($foreignKeys as $fk) {
            DB::statement("
                ALTER TABLE {$fk->TABLE_NAME} 
                ADD CONSTRAINT {$fk->CONSTRAINT_NAME} 
                FOREIGN KEY ({$fk->COLUMN_NAME}) 
                REFERENCES {$fk->REFERENCED_TABLE_NAME}({$fk->REFERENCED_COLUMN_NAME})
            ");
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // If needed, you can revert the collations back to general_ci here
    }
};