<?php

declare(strict_types=1);

namespace App\Guards\Login;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

/**
 * Guard to check if user's business has an active subscription.
 *
 * Returns true (passes) if subscription exists, which skips the subscription step.
 * Returns false (fails) if no subscription exists, which executes the subscription step.
 */
class SubscriptionExistsGuard implements GuardContract
{
    /**
     * Determine if the guard passes.
     *
     * @param  Request  $request  The current request
     * @return bool True if subscription exists (skip step), false if subscription is needed
     */
    public function passes(Request $request): bool
    {
        $user = $request->user();

        // If no user, can't check subscription
        if (!$user) {
            return false;
        }

        // If user has no business, no subscription exists
        if (!$user->business) {
            return false;
        }

        // Check if business has an active subscription
        return $user->business->subscription()
            ->where('status', 'active')
            ->exists();
    }

    /**
     * Hook called when entering this step.
     *
     * @param  Request  $request  The current request
     */
    public function onEnter(Request $request): void
    {
        // Optional: Log subscription check entry
    }

    /**
     * Hook called when exiting this step.
     *
     * @param  Request  $request  The current request
     */
    public function onExit(Request $request): void
    {
        // Optional: Log subscription check exit
    }

    /**
     * Hook called when this guard passes (subscription exists).
     *
     * @param  Request  $request  The current request
     */
    public function onPass(Request $request): void
    {
        // Optional: Log that subscription exists
    }

    /**
     * Hook called when this guard fails (subscription needed).
     *
     * @param  Request  $request  The current request
     */
    public function onFail(Request $request): void
    {
        // Optional: Log that subscription is needed
    }
}
