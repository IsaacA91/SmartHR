<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration will add nullable `start_date` and `end_date` DATE columns to the
     * existing `leaverequests` table if they don't already exist. It's defensive so it
     * is safe to run even if the columns are already present.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('leaverequests')) {
            // The table doesn't exist in the database; nothing to do here.
            return;
        }

        Schema::table('leaverequests', function (Blueprint $table) {
            if (!Schema::hasColumn('leaverequests', 'start_date')) {
                $table->date('start_date')->nullable()->after('employeeID');
            }

            if (!Schema::hasColumn('leaverequests', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * Drops the columns if they exist.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('leaverequests')) {
            return;
        }

        Schema::table('leaverequests', function (Blueprint $table) {
            if (Schema::hasColumn('leaverequests', 'end_date')) {
                $table->dropColumn('end_date');
            }

            if (Schema::hasColumn('leaverequests', 'start_date')) {
                $table->dropColumn('start_date');
            }
        });
    }
};
