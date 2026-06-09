<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->createVillagesTable();
        $this->syncUsersTable();
        $this->createVillageProfilesTable();

        $this->createPostCategoriesTable();
        $this->createPostsTable();
        $this->createMediaTable();

        $this->createPotentialCategoriesTable();
        $this->createPotentialsTable();

        $this->createHamletsTable();
        $this->createRwsTable();
        $this->createRtsTable();
        $this->createHouseholdsTable();
        $this->createCitizensTable();

        $this->createLetterTypesTable();
        $this->createLetterRequestsTable();
        $this->createGeneratedLettersTable();

        $this->createComplaintCategoriesTable();
        $this->createComplaintsTable();
        $this->createComplaintCommentsTable();
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_comments');
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('complaint_categories');
        Schema::dropIfExists('generated_letters');
        Schema::dropIfExists('letter_requests');
        Schema::dropIfExists('letter_types');
        Schema::dropIfExists('citizens');
        Schema::dropIfExists('households');
        Schema::dropIfExists('rts');
        Schema::dropIfExists('rws');
        Schema::dropIfExists('hamlets');
        Schema::dropIfExists('potentials');
        Schema::dropIfExists('potential_categories');
        Schema::dropIfExists('media');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_categories');
        Schema::dropIfExists('village_profiles');

        if (Schema::hasTable('users')) {
            if (Schema::hasIndex('users', 'users_nik_unique')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropUnique('users_nik_unique');
                });
            }

            if (Schema::hasIndex('users', 'users_status_index')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropIndex('users_status_index');
                });
            }

            if (Schema::hasColumn('users', 'village_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropForeign(['village_id']);
                });
            }

            Schema::table('users', function (Blueprint $table) {
                foreach (['nik', 'phone', 'status', 'village_id'] as $column) {
                    if (Schema::hasColumn('users', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        Schema::dropIfExists('villages');
    }

    private function syncUsersTable(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'nik')) {
                $table->string('nik')->nullable()->after('email');
            }

            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('nik');
            }

            if (! Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active')->after('phone');
            }

            if (! Schema::hasColumn('users', 'village_id')) {
                $table->foreignId('village_id')
                    ->nullable()
                    ->after('status')
                    ->constrained('villages')
                    ->nullOnDelete();
            }
        });

        if (! Schema::hasIndex('users', 'users_nik_unique')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('nik', 'users_nik_unique');
            });
        }

        if (! Schema::hasIndex('users', 'users_status_index')) {
            Schema::table('users', function (Blueprint $table) {
                $table->index('status', 'users_status_index');
            });
        }

        if (Schema::hasColumn('users', 'is_active') && Schema::hasColumn('users', 'status')) {
            DB::table('users')->where('is_active', true)->update(['status' => 'active']);
            DB::table('users')->where('is_active', false)->update(['status' => 'inactive']);
        }
    }

    private function createVillagesTable(): void
    {
        if (Schema::hasTable('villages')) {
            return;
        }

        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('district');
            $table->string('regency');
            $table->string('province');
            $table->string('postal_code')->nullable();
            $table->timestamps();
        });
    }

    private function createVillageProfilesTable(): void
    {
        if (Schema::hasTable('village_profiles')) {
            return;
        }

        Schema::create('village_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('logo_path')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique('village_id', 'village_profiles_village_id_unique');
        });
    }

    private function createPostCategoriesTable(): void
    {
        if (Schema::hasTable('post_categories')) {
            return;
        }

        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    private function createPostsTable(): void
    {
        if (Schema::hasTable('posts')) {
            return;
        }

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('post_categories')->restrictOnDelete();
            $table->foreignId('author_id')->constrained('users')->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('status');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['village_id', 'status'], 'posts_village_status_index');
        });
    }

    private function createMediaTable(): void
    {
        if (Schema::hasTable('media')) {
            return;
        }

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->nullable()->constrained()->nullOnDelete();
            $table->nullableMorphs('mediable');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('mime_type')->nullable();
            $table->string('disk')->default('public');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    private function createPotentialCategoriesTable(): void
    {
        if (Schema::hasTable('potential_categories')) {
            return;
        }

        Schema::create('potential_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    private function createPotentialsTable(): void
    {
        if (Schema::hasTable('potentials')) {
            return;
        }

        Schema::create('potentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('potential_categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['village_id', 'status'], 'potentials_village_status_index');
        });
    }

    private function createHamletsTable(): void
    {
        if (Schema::hasTable('hamlets')) {
            return;
        }

        Schema::create('hamlets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->nullable();
            $table->timestamps();
        });
    }

    private function createRwsTable(): void
    {
        if (Schema::hasTable('rws')) {
            return;
        }

        Schema::create('rws', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hamlet_id')->constrained()->cascadeOnDelete();
            $table->string('number');
            $table->timestamps();

            $table->unique(['hamlet_id', 'number'], 'rws_hamlet_number_unique');
        });
    }

    private function createRtsTable(): void
    {
        if (Schema::hasTable('rts')) {
            return;
        }

        Schema::create('rts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rw_id')->constrained('rws')->cascadeOnDelete();
            $table->string('number');
            $table->timestamps();

            $table->unique(['rw_id', 'number'], 'rts_rw_number_unique');
        });
    }

    private function createHouseholdsTable(): void
    {
        if (Schema::hasTable('households')) {
            return;
        }

        Schema::create('households', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->string('no_kk')->unique();
            $table->unsignedBigInteger('head_citizen_id')->nullable();
            $table->foreignId('hamlet_id')->constrained()->restrictOnDelete();
            $table->foreignId('rw_id')->constrained('rws')->restrictOnDelete();
            $table->foreignId('rt_id')->constrained('rts')->restrictOnDelete();
            $table->text('address');
            $table->timestamps();
            $table->softDeletes();

            $table->index('head_citizen_id', 'households_head_citizen_id_index');
        });
    }

    private function createCitizensTable(): void
    {
        if (Schema::hasTable('citizens')) {
            return;
        }

        Schema::create('citizens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('household_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nik')->unique();
            $table->string('full_name');
            $table->string('gender');
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('religion')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('occupation')->nullable();
            $table->string('education')->nullable();
            $table->text('address')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

            $table->index('status', 'citizens_status_index');
        });

        Schema::table('households', function (Blueprint $table) {
            $table->foreign('head_citizen_id')
                ->references('id')
                ->on('citizens')
                ->nullOnDelete();
        });
    }

    private function createLetterTypesTable(): void
    {
        if (Schema::hasTable('letter_types')) {
            return;
        }

        Schema::create('letter_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code');
            $table->string('template_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    private function createLetterRequestsTable(): void
    {
        if (Schema::hasTable('letter_requests')) {
            return;
        }

        Schema::create('letter_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->foreignId('letter_type_id')->constrained()->restrictOnDelete();
            $table->foreignId('applicant_user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('citizen_id')->nullable()->constrained()->nullOnDelete();
            $table->string('request_number')->unique();
            $table->json('form_payload');
            $table->string('status');
            $table->timestamp('submitted_at');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['village_id', 'status'], 'letter_requests_village_status_index');
        });
    }

    private function createGeneratedLettersTable(): void
    {
        if (Schema::hasTable('generated_letters')) {
            return;
        }

        Schema::create('generated_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('letter_request_id')->constrained()->cascadeOnDelete();
            $table->string('file_name');
            $table->string('file_path');
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique('letter_request_id', 'generated_letters_letter_request_id_unique');
        });
    }

    private function createComplaintCategoriesTable(): void
    {
        if (Schema::hasTable('complaint_categories')) {
            return;
        }

        Schema::create('complaint_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    private function createComplaintsTable(): void
    {
        if (Schema::hasTable('complaints')) {
            return;
        }

        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('complaint_categories')->nullOnDelete();
            $table->foreignId('citizen_user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('ticket_number')->unique();
            $table->string('title');
            $table->longText('description');
            $table->string('status');
            $table->string('priority')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['village_id', 'status'], 'complaints_village_status_index');
        });
    }

    private function createComplaintCommentsTable(): void
    {
        if (Schema::hasTable('complaint_comments')) {
            return;
        }

        Schema::create('complaint_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->text('comment');
            $table->boolean('is_internal')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
