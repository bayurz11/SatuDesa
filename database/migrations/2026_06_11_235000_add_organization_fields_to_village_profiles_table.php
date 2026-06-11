<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->string('organization_page_title')->nullable()->after('history_sidebar_description');
            $table->text('organization_page_description')->nullable()->after('organization_page_title');
            $table->string('organization_section_badge')->nullable()->after('organization_page_description');
            $table->string('organization_section_title')->nullable()->after('organization_section_badge');
            $table->text('organization_section_description')->nullable()->after('organization_section_title');
            $table->json('organization_head')->nullable()->after('organization_section_description');
            $table->json('organization_partner')->nullable()->after('organization_head');
            $table->json('organization_secretary')->nullable()->after('organization_partner');
            $table->json('organization_kaur_items')->nullable()->after('organization_secretary');
            $table->json('organization_kasi_items')->nullable()->after('organization_kaur_items');
            $table->json('organization_dusun_items')->nullable()->after('organization_kasi_items');
            $table->text('organization_note')->nullable()->after('organization_dusun_items');
            $table->string('organization_sidebar_title')->nullable()->after('organization_note');
            $table->text('organization_sidebar_description')->nullable()->after('organization_sidebar_title');
        });
    }

    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'organization_page_title',
                'organization_page_description',
                'organization_section_badge',
                'organization_section_title',
                'organization_section_description',
                'organization_head',
                'organization_partner',
                'organization_secretary',
                'organization_kaur_items',
                'organization_kasi_items',
                'organization_dusun_items',
                'organization_note',
                'organization_sidebar_title',
                'organization_sidebar_description',
            ]);
        });
    }
};
