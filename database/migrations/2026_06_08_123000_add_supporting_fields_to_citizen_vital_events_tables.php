<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citizen_births', function (Blueprint $table) {
            $table->string('birth_weight')->nullable()->after('birth_time');
            $table->string('birth_length')->nullable()->after('birth_weight');
            $table->string('witness_1_name')->nullable()->after('reporter_relation');
            $table->string('witness_2_name')->nullable()->after('witness_1_name');
        });

        Schema::table('citizen_arrivals', function (Blueprint $table) {
            $table->string('origin_no_kk')->nullable()->after('origin_region');
            $table->unsignedSmallInteger('moved_member_count')->nullable()->after('origin_no_kk');
        });

        Schema::table('citizen_deaths', function (Blueprint $table) {
            $table->string('witness_1_name')->nullable()->after('reporter_relation');
            $table->string('witness_2_name')->nullable()->after('witness_1_name');
        });
    }

    public function down(): void
    {
        Schema::table('citizen_births', function (Blueprint $table) {
            $table->dropColumn(['birth_weight', 'birth_length', 'witness_1_name', 'witness_2_name']);
        });

        Schema::table('citizen_arrivals', function (Blueprint $table) {
            $table->dropColumn(['origin_no_kk', 'moved_member_count']);
        });

        Schema::table('citizen_deaths', function (Blueprint $table) {
            $table->dropColumn(['witness_1_name', 'witness_2_name']);
        });
    }
};
