<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AppSettingKey;
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

    public static function bool(AppSettingKey $key, bool $default = false): bool
    {
        if (! self::tableExists()) {
            return $default;
        }

        $value = self::query()->where('key', $key->value)->value('value');

        if ($value === null) {
            return $default;
        }

        return filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) ?? $default;
    }

    public static function setBool(AppSettingKey $key, bool $value): void
    {
        if (! self::tableExists()) {
            return;
        }

        self::query()->updateOrCreate(
            ['key' => $key->value],
            ['value' => $value ? '1' : '0'],
        );
    }

    public static function registrationHumanVerificationEnabled(): bool
    {
        return self::bool(AppSettingKey::RegistrationHumanVerificationEnabled);
    }

    /**
     * @param  array<string, mixed>  $default
     * @return array<string, mixed>
     */
    public static function array(AppSettingKey $key, array $default = []): array
    {
        if (! self::tableExists()) {
            return $default;
        }

        $value = self::query()->where('key', $key->value)->value('value');

        if (! is_string($value) || $value === '') {
            return $default;
        }

        $decoded = json_decode($value, true);

        if (! is_array($decoded)) {
            return $default;
        }

        /** @var array<string, mixed> $decoded */
        return $decoded;
    }

    /**
     * @param  array<string, mixed>  $value
     */
    public static function setArray(AppSettingKey $key, array $value): void
    {
        if (! self::tableExists()) {
            return;
        }

        self::query()->updateOrCreate(
            ['key' => $key->value],
            ['value' => json_encode($value, JSON_THROW_ON_ERROR)],
        );
    }

    public static function setRegistrationHumanVerificationEnabled(bool $enabled): void
    {
        self::setBool(AppSettingKey::RegistrationHumanVerificationEnabled, $enabled);
    }

    private static function tableExists(): bool
    {
        return Schema::hasTable('app_settings');
    }
}
