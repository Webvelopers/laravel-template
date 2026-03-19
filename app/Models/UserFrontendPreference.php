<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class UserFrontendPreference extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'template',
    ];

    public static function templateFor(?User $user): ?string
    {
        if (! $user instanceof User) {
            return null;
        }

        /** @var string|null $template */
        $template = self::query()
            ->where('user_id', $user->getKey())
            ->value('template');

        return $template;
    }

    public static function updateTemplateFor(User $user, string $template): void
    {
        self::query()->updateOrCreate(
            ['user_id' => $user->getKey()],
            ['template' => $template],
        );
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'template' => 'string',
        ];
    }
}
