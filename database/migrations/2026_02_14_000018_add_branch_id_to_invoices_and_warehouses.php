<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'branch_id')) {
                $table->uuid('branch_id')->after('company_id');
                $table->foreign('branch_id')->references('id')->on('branches');
                $table->index('branch_id');
            }
        });
        Schema::table('warehouses', function (Blueprint $table) {
            if (!Schema::hasColumn('warehouses', 'branch_id')) {
                $table->uuid('branch_id')->after('company_id');
                $table->foreign('branch_id')->references('id')->on('branches');
                $table->index('branch_id');
            }
        });
    }
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'branch_id')) {
                $table->dropForeign(['branch_id']);
                $table->dropIndex(['branch_id']);
                $table->dropColumn('branch_id');
            }
        });
        Schema::table('warehouses', function (Blueprint $table) {
            if (Schema::hasColumn('warehouses', 'branch_id')) {
                $table->dropForeign(['branch_id']);
                $table->dropIndex(['branch_id']);
                $table->dropColumn('branch_id');
            }
        });
    }
};
