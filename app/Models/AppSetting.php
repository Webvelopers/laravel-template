<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

final class AppSetting extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
    ];

    public static function getBool(string $key, bool $default = false): bool
    {
        if (! Schema::hasTable('app_settings')) {
            return $default;
        }

        $value = self::query()->where('key', $key)->value('value');

        if ($value === null) {
            return $default;
        }

        return filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) ?? $default;
    }

    public static function setBool(string $key, bool $value): void
    {
        if (! Schema::hasTable('app_settings')) {
            return;
        }

        self::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value ? '1' : '0'],
        );
    }
}
