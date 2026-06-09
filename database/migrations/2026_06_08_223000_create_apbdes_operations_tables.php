<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apbdes_payment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscal_year_id')->constrained('apbdes_fiscal_years')->cascadeOnDelete();
            $table->foreignId('budget_line_id')->nullable()->constrained('apbdes_budget_lines')->nullOnDelete();
            $table->string('request_number')->unique();
            $table->date('request_date');
            $table->string('payee_name');
            $table->decimal('amount', 18, 2)->default(0);
            $table->string('status')->default('draft');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('apbdes_realizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscal_year_id')->constrained('apbdes_fiscal_years')->cascadeOnDelete();
            $table->foreignId('budget_line_id')->constrained('apbdes_budget_lines')->cascadeOnDelete();
            $table->foreignId('payment_request_id')->nullable()->constrained('apbdes_payment_requests')->nullOnDelete();
            $table->date('transaction_date');
            $table->string('reference_number');
            $table->string('payment_method')->default('cash');
            $table->decimal('amount', 18, 2)->default(0);
            $table->string('status')->default('posted');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('apbdes_cash_book_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscal_year_id')->constrained('apbdes_fiscal_years')->cascadeOnDelete();
            $table->foreignId('realization_id')->nullable()->constrained('apbdes_realizations')->nullOnDelete();
            $table->date('entry_date');
            $table->string('reference_number');
            $table->string('description');
            $table->decimal('debit_amount', 18, 2)->default(0);
            $table->decimal('credit_amount', 18, 2)->default(0);
            $table->decimal('balance', 18, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('apbdes_bank_book_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscal_year_id')->constrained('apbdes_fiscal_years')->cascadeOnDelete();
            $table->foreignId('realization_id')->nullable()->constrained('apbdes_realizations')->nullOnDelete();
            $table->date('entry_date');
            $table->string('reference_number');
            $table->string('bank_name')->nullable();
            $table->string('description');
            $table->decimal('debit_amount', 18, 2)->default(0);
            $table->decimal('credit_amount', 18, 2)->default(0);
            $table->decimal('balance', 18, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('apbdes_tax_book_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscal_year_id')->constrained('apbdes_fiscal_years')->cascadeOnDelete();
            $table->foreignId('realization_id')->nullable()->constrained('apbdes_realizations')->nullOnDelete();
            $table->date('entry_date');
            $table->string('reference_number');
            $table->string('tax_type');
            $table->string('description');
            $table->decimal('tax_base_amount', 18, 2)->default(0);
            $table->decimal('withheld_amount', 18, 2)->default(0);
            $table->decimal('remitted_amount', 18, 2)->default(0);
            $table->string('status')->default('withheld');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apbdes_tax_book_entries');
        Schema::dropIfExists('apbdes_bank_book_entries');
        Schema::dropIfExists('apbdes_cash_book_entries');
        Schema::dropIfExists('apbdes_realizations');
        Schema::dropIfExists('apbdes_payment_requests');
    }
};
