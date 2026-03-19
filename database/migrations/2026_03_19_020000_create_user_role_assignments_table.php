<?php

declare(strict_types=1);

use App\Enums\UserRole;
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
        Schema::create('user_role_assignments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role')->default(UserRole::User->value);
            $table->timestamps();
            $table->unique('user_id');
        });

        if (Schema::hasColumn('users', 'role')) {
            DB::table('users')
                ->select(['id', 'role'])
                ->orderBy('id')
                ->chunkById(100, function ($users): void {
                    $now = now();

                    $assignments = $users
                        ->filter(fn (object $user): bool => is_string($user->role) && $user->role !== '')
                        ->map(fn (object $user): array => [
                            'user_id' => $user->id,
                            'role' => $user->role,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ])
                        ->all();

                    if ($assignments !== []) {
                        DB::table('user_role_assignments')->insert($assignments);
                    }
                });

            Schema::table('users', function (Blueprint $table): void {
                $table->dropColumn('role');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->string('role')->default(UserRole::User->value)->after('password');
            });

            DB::table('user_role_assignments')
                ->select(['user_id', 'role'])
                ->orderBy('id')
                ->chunkById(100, function ($assignments): void {
                    foreach ($assignments as $assignment) {
                        DB::table('users')
                            ->where('id', $assignment->user_id)
                            ->update(['role' => $assignment->role]);
                    }
                });
        }

        Schema::dropIfExists('user_role_assignments');
    }
};
