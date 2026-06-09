<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('citizen_births')) {
            Schema::table('citizen_births', function (Blueprint $table) {
                if (!Schema::hasColumn('citizen_births', 'father_nik')) {
                    $table->string('father_nik')->nullable()->after('household_id');
                }
                if (!Schema::hasColumn('citizen_births', 'mother_nik')) {
                    $table->string('mother_nik')->nullable()->after('father_nik');
                }
                if (!Schema::hasColumn('citizen_births', 'birth_time')) {
                    $table->time('birth_time')->nullable()->after('mother_name');
                }
                if (!Schema::hasColumn('citizen_births', 'birth_order')) {
                    $table->unsignedTinyInteger('birth_order')->nullable()->after('birth_time');
                }
                if (!Schema::hasColumn('citizen_births', 'birth_type')) {
                    $table->string('birth_type')->nullable()->after('birth_order');
                }
                if (!Schema::hasColumn('citizen_births', 'reporter_relation')) {
                    $table->string('reporter_relation')->nullable()->after('reporter_name');
                }
            });
        }

        if (Schema::hasTable('citizen_arrivals')) {
            Schema::table('citizen_arrivals', function (Blueprint $table) {
                if (!Schema::hasColumn('citizen_arrivals', 'reporter_name')) {
                    $table->string('reporter_name')->nullable()->after('arrival_reason');
                }
                if (!Schema::hasColumn('citizen_arrivals', 'arrival_classification')) {
                    $table->string('arrival_classification')->nullable()->after('moving_certificate_number');
                }
                if (!Schema::hasColumn('citizen_arrivals', 'reporter_relation')) {
                    $table->string('reporter_relation')->nullable()->after('arrival_reason');
                }
            });
        }

        if (Schema::hasTable('citizen_deaths')) {
            Schema::table('citizen_deaths', function (Blueprint $table) {
                if (!Schema::hasColumn('citizen_deaths', 'reporter_relation')) {
                    $table->string('reporter_relation')->nullable()->after('reporter_name');
                }
                if (!Schema::hasColumn('citizen_deaths', 'burial_place')) {
                    $table->string('burial_place')->nullable()->after('reporter_relation');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('citizen_births')) {
            Schema::table('citizen_births', function (Blueprint $table) {
                foreach (['father_nik', 'mother_nik', 'birth_time', 'birth_order', 'birth_type', 'reporter_relation'] as $column) {
                    if (Schema::hasColumn('citizen_births', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('citizen_arrivals')) {
            Schema::table('citizen_arrivals', function (Blueprint $table) {
                foreach (['reporter_name', 'arrival_classification', 'reporter_relation'] as $column) {
                    if (Schema::hasColumn('citizen_arrivals', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('citizen_deaths')) {
            Schema::table('citizen_deaths', function (Blueprint $table) {
                foreach (['reporter_relation', 'burial_place'] as $column) {
                    if (Schema::hasColumn('citizen_deaths', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
