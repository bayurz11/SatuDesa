<?php

use App\Support\StoredContentSanitizer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (! Schema::hasColumn('posts', 'content_raw')) {
                $table->longText('content_raw')->nullable()->after('content');
            }

            if (! Schema::hasColumn('posts', 'content_safe')) {
                $table->longText('content_safe')->nullable()->after('content_raw');
            }
        });

        Schema::table('potentials', function (Blueprint $table) {
            if (! Schema::hasColumn('potentials', 'content_raw')) {
                $table->longText('content_raw')->nullable()->after('content');
            }

            if (! Schema::hasColumn('potentials', 'content_safe')) {
                $table->longText('content_safe')->nullable()->after('content_raw');
            }

            if (! Schema::hasColumn('potentials', 'facilities_raw')) {
                $table->text('facilities_raw')->nullable()->after('facilities');
            }

            if (! Schema::hasColumn('potentials', 'facilities_safe')) {
                $table->text('facilities_safe')->nullable()->after('facilities_raw');
            }

            if (! Schema::hasColumn('potentials', 'opportunities_raw')) {
                $table->text('opportunities_raw')->nullable()->after('opportunities');
            }

            if (! Schema::hasColumn('potentials', 'opportunities_safe')) {
                $table->text('opportunities_safe')->nullable()->after('opportunities_raw');
            }
        });

        DB::table('posts')
            ->select(['id', 'content', 'content_raw', 'content_safe'])
            ->orderBy('id')
            ->chunkById(100, function ($posts): void {
                foreach ($posts as $post) {
                    $rawContent = $post->content_raw ?? $post->content;

                    DB::table('posts')
                        ->where('id', $post->id)
                        ->update([
                            'content_raw' => $rawContent,
                            'content_safe' => StoredContentSanitizer::clean($post->content_safe ?? $rawContent),
                        ]);
                }
            });

        DB::table('potentials')
            ->select([
                'id',
                'content',
                'content_raw',
                'content_safe',
                'facilities',
                'facilities_raw',
                'facilities_safe',
                'opportunities',
                'opportunities_raw',
                'opportunities_safe',
            ])
            ->orderBy('id')
            ->chunkById(100, function ($potentials): void {
                foreach ($potentials as $potential) {
                    $rawContent = $potential->content_raw ?? $potential->content;
                    $rawFacilities = $potential->facilities_raw ?? $potential->facilities;
                    $rawOpportunities = $potential->opportunities_raw ?? $potential->opportunities;

                    DB::table('potentials')
                        ->where('id', $potential->id)
                        ->update([
                            'content_raw' => $rawContent,
                            'content_safe' => StoredContentSanitizer::clean($potential->content_safe ?? $rawContent),
                            'facilities_raw' => $rawFacilities,
                            'facilities_safe' => StoredContentSanitizer::clean($potential->facilities_safe ?? $rawFacilities),
                            'opportunities_raw' => $rawOpportunities,
                            'opportunities_safe' => StoredContentSanitizer::clean($potential->opportunities_safe ?? $rawOpportunities),
                        ]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('potentials', function (Blueprint $table) {
            $columns = [
                'content_raw',
                'content_safe',
                'facilities_raw',
                'facilities_safe',
                'opportunities_raw',
                'opportunities_safe',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('potentials', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('posts', function (Blueprint $table) {
            foreach (['content_raw', 'content_safe'] as $column) {
                if (Schema::hasColumn('posts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
