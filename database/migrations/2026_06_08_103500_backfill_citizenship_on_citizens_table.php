<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('citizens') || !Schema::hasColumn('citizens', 'citizenship')) {
            return;
        }

        DB::table('citizens')
            ->whereNull('citizenship')
            ->orWhere('citizenship', '')
            ->update(['citizenship' => 'WNI']);
    }

    public function down(): void
    {
        // No-op: this migration only normalizes existing data.
    }
};
