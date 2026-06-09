<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->timestamp('event_at')->nullable()->after('published_at');
            $table->string('event_location')->nullable()->after('event_at');
        });

        DB::table('posts')
            ->where('type', 'announcement')
            ->whereNull('event_at')
            ->update([
                'event_at' => DB::raw('published_at'),
            ]);
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['event_at', 'event_location']);
        });
    }
};
