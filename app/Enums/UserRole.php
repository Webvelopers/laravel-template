<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case User = 'user';

    /**
     * @return list<string>
     */
    public static function allCapabilityKeys(): array
    {
        return [
            'admin.access',
            'admin.manage_settings',
            'admin.manage_roles',
            'dashboard.access',
            'profile.manage_own',
            'frontend.choose_template',
        ];
    }

    /**
     * @return list<string>
     */
    public function defaultCapabilityKeys(): array
    {
        return match ($this) {
            self::Admin => [
                'admin.access',
                'admin.manage_settings',
                'admin.manage_roles',
                'profile.manage_own',
            ],
            self::User => [
                'dashboard.access',
                'profile.manage_own',
                'frontend.choose_template',
            ],
        };
    }

    /**
     * @return list<string>
     */
    public function protectedCapabilityKeys(): array
    {
        return match ($this) {
            self::Admin => [
                'admin.access',
                'admin.manage_roles',
                'admin.manage_settings',
            ],
            self::User => [],
        };
    }

    public function isAdmin(): bool
    {
        return $this === self::Admin;
    }

    public function isUser(): bool
    {
        return $this === self::User;
    }
}
