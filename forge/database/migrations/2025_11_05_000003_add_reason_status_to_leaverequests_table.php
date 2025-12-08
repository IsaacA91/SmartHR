<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds `reason`, `status`, and `admin_remarks` to `leaverequests` if they don't exist.
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('leaverequests')) {
            return;
        }

        Schema::table('leaverequests', function (Blueprint $table) {
            if (! Schema::hasColumn('leaverequests', 'reason')) {
                $table->text('reason')->nullable()->after('endDate');
            }

            if (! Schema::hasColumn('leaverequests', 'status')) {
                $table->string('status', 50)->default('pending')->after('reason');
            }

            if (! Schema::hasColumn('leaverequests', 'admin_remarks')) {
                $table->text('admin_remarks')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (! Schema::hasTable('leaverequests')) {
            return;
        }

        Schema::table('leaverequests', function (Blueprint $table) {
            if (Schema::hasColumn('leaverequests', 'admin_remarks')) {
                $table->dropColumn('admin_remarks');
            }

            if (Schema::hasColumn('leaverequests', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('leaverequests', 'reason')) {
                $table->dropColumn('reason');
            }
        });
    }
};
