<?php

declare(strict_types=1);

namespace App\Enums;

enum AppSettingKey: string
{
    case RegistrationHumanVerificationEnabled = 'registration_human_verification_enabled';
    case RoleCapabilities = 'role_capabilities';
}
