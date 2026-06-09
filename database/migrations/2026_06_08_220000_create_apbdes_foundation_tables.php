<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apbdes_fiscal_years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('year');
            $table->string('title');
            $table->string('status')->default('draft');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('apbdes_regulation_number')->nullable();
            $table->date('apbdes_regulation_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['village_id', 'year'], 'apbdes_fiscal_years_village_year_unique');
        });

        Schema::create('apbdes_funding_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code');
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['village_id', 'code'], 'apbdes_funding_sources_village_code_unique');
        });

        Schema::create('apbdes_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('apbdes_accounts')->nullOnDelete();
            $table->string('code');
            $table->string('name');
            $table->string('type');
            $table->unsignedTinyInteger('level')->default(1);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['village_id', 'code'], 'apbdes_accounts_village_code_unique');
            $table->index(['type', 'level'], 'apbdes_accounts_type_level_index');
        });

        Schema::create('apbdes_budget_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscal_year_id')->constrained('apbdes_fiscal_years')->cascadeOnDelete();
            $table->foreignId('account_id')->constrained('apbdes_accounts')->restrictOnDelete();
            $table->foreignId('funding_source_id')->nullable()->constrained('apbdes_funding_sources')->nullOnDelete();
            $table->string('description');
            $table->decimal('amount', 18, 2)->default(0);
            $table->decimal('realized_amount', 18, 2)->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['fiscal_year_id', 'account_id'], 'apbdes_budget_lines_year_account_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apbdes_budget_lines');
        Schema::dropIfExists('apbdes_accounts');
        Schema::dropIfExists('apbdes_funding_sources');
        Schema::dropIfExists('apbdes_fiscal_years');
    }
};
