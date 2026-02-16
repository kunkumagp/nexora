<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id');
            $table->uuid('supplier_id');
            $table->uuid('branch_id');
            $table->uuid('user_id');
            $table->date('purchase_date');
            $table->decimal('total', 15, 2);
            $table->decimal('paid', 15, 2)->default(0);
            $table->string('status')->default('unpaid');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('user_id')->references('id')->on('users');
            $table->index(['company_id', 'supplier_id', 'branch_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
