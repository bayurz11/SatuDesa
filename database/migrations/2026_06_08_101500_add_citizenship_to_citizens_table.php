<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('citizens') || Schema::hasColumn('citizens', 'citizenship')) {
            return;
        }

        Schema::table('citizens', function (Blueprint $table) {
            $table->string('citizenship')->nullable()->after('education');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('citizens') || !Schema::hasColumn('citizens', 'citizenship')) {
            return;
        }

        Schema::table('citizens', function (Blueprint $table) {
            $table->dropColumn('citizenship');
        });
    }
};
