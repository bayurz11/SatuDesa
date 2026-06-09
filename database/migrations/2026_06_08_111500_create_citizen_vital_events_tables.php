<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('citizen_births')) {
            Schema::create('citizen_births', function (Blueprint $table) {
                $table->id();
                $table->foreignId('village_id')->constrained()->cascadeOnDelete();
                $table->foreignId('citizen_id')->constrained()->cascadeOnDelete();
                $table->foreignId('household_id')->nullable()->constrained()->nullOnDelete();
                $table->string('father_name')->nullable();
                $table->string('mother_name')->nullable();
                $table->string('birth_attendant')->nullable();
                $table->string('birth_certificate_number')->nullable();
                $table->string('reporter_name')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->unique('citizen_id', 'citizen_births_citizen_id_unique');
            });
        }

        if (!Schema::hasTable('citizen_arrivals')) {
            Schema::create('citizen_arrivals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('village_id')->constrained()->cascadeOnDelete();
                $table->foreignId('citizen_id')->constrained()->cascadeOnDelete();
                $table->foreignId('household_id')->nullable()->constrained()->nullOnDelete();
                $table->date('arrival_date');
                $table->text('origin_address')->nullable();
                $table->string('origin_region')->nullable();
                $table->string('moving_certificate_number')->nullable();
                $table->string('arrival_reason')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('citizen_deaths')) {
            Schema::create('citizen_deaths', function (Blueprint $table) {
                $table->id();
                $table->foreignId('village_id')->constrained()->cascadeOnDelete();
                $table->foreignId('citizen_id')->constrained()->cascadeOnDelete();
                $table->date('death_date');
                $table->time('death_time')->nullable();
                $table->string('death_place')->nullable();
                $table->string('cause_of_death')->nullable();
                $table->string('certifier')->nullable();
                $table->string('death_certificate_number')->nullable();
                $table->string('reporter_name')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->unique('citizen_id', 'citizen_deaths_citizen_id_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('citizen_deaths');
        Schema::dropIfExists('citizen_arrivals');
        Schema::dropIfExists('citizen_births');
    }
};
