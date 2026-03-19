<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateHumanVerificationRequest;
use App\Models\AppSetting;
use App\Support\HumanVerificationChallenge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class HumanVerificationController extends Controller
{
    public function update(UpdateHumanVerificationRequest $request): RedirectResponse
    {
        AppSetting::setRegistrationHumanVerificationEnabled(
            $request->boolean('registration_human_verification_enabled'),
        );

        return back()->with('status', 'human-verification-updated');
    }

    public function refresh(Request $request, HumanVerificationChallenge $humanVerificationChallenge): JsonResponse|RedirectResponse
    {
        $humanVerificationChallenge->refresh();

        if ($request->wantsJson()) {
            return new JsonResponse([
                'image' => $humanVerificationChallenge->image(),
            ]);
        }

        return back();
    }
}
