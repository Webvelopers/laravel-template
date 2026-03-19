<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_frontend_preferences', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('template')->default('default');
            $table->timestamps();
            $table->unique('user_id');
        });

        if (Schema::hasColumn('users', 'frontend_template')) {
            DB::table('users')
                ->select(['id', 'frontend_template'])
                ->orderBy('id')
                ->chunkById(100, function ($users): void {
                    $now = now();

                    $preferences = $users
                        ->filter(fn (object $user): bool => is_string($user->frontend_template) && $user->frontend_template !== '')
                        ->map(fn (object $user): array => [
                            'user_id' => $user->id,
                            'template' => $user->frontend_template,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ])
                        ->all();

                    if ($preferences !== []) {
                        DB::table('user_frontend_preferences')->insert($preferences);
                    }
                });

            Schema::table('users', function (Blueprint $table): void {
                $table->dropColumn('frontend_template');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('users', 'frontend_template')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->string('frontend_template')->default('default')->after('password');
            });

            DB::table('user_frontend_preferences')
                ->select(['user_id', 'template'])
                ->orderBy('id')
                ->chunkById(100, function ($preferences): void {
                    foreach ($preferences as $preference) {
                        DB::table('users')
                            ->where('id', $preference->user_id)
                            ->update(['frontend_template' => $preference->template]);
                    }
                });
        }

        Schema::dropIfExists('user_frontend_preferences');
    }
};
