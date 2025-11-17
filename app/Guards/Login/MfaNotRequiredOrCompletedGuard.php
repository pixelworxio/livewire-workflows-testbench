<?php

declare(strict_types=1);

namespace App\Guards\Login;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

/**
 * Guard to check if MFA is required and if it's been completed.
 *
 * Returns true (passes) if:
 *   - User doesn't have MFA enabled, OR
 *   - MFA was already completed (mfa_sent_at is null)
 * Returns false (fails) if MFA is required and not yet completed.
 */
class MfaNotRequiredOrCompletedGuard implements GuardContract
{
    /**
     * Determine if the guard passes.
     *
     * @param  Request  $request  The current request
     * @return bool True if MFA step can be skipped, false if MFA is required
     */
    public function passes(Request $request): bool
    {
        $user = $request->user();

        // If no user is authenticated, skip MFA
        if (!$user) {
            return true;
        }

        // If user doesn't have MFA enabled, skip MFA step
        if (!$user->enabled_mfa) {
            return true;
        }

        // If MFA was already validated (mfa_sent_at is null), skip MFA step
        return $user->mfa_sent_at === null;
    }

    /**
     * Hook called when entering this step.
     *
     * @param  Request  $request  The current request
     */
    public function onEnter(Request $request): void
    {
        // Optional: Log MFA step entry
    }

    /**
     * Hook called when exiting this step.
     *
     * @param  Request  $request  The current request
     */
    public function onExit(Request $request): void
    {
        // Optional: Log MFA step exit
    }

    /**
     * Hook called when this guard passes (MFA not required or completed).
     *
     * @param  Request  $request  The current request
     */
    public function onPass(Request $request): void
    {
        // Optional: Log that MFA was skipped
    }

    /**
     * Hook called when this guard fails (MFA is required).
     *
     * @param  Request  $request  The current request
     */
    public function onFail(Request $request): void
    {
        // Optional: Log that MFA is required
    }
}
