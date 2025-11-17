<?php

declare(strict_types=1);

namespace App\Guards\Login;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

/**
 * Guard to check if user has a valid payment method on file.
 *
 * Returns true (passes) if payment method exists, which skips the payment method step.
 * Returns false (fails) if no payment method exists, which executes the payment method step.
 */
class PaymentMethodExistsGuard implements GuardContract
{
    /**
     * Determine if the guard passes.
     *
     * @param  Request  $request  The current request
     * @return bool True if payment method exists (skip step), false if payment method is needed
     */
    public function passes(Request $request): bool
    {
        $user = $request->user();

        // If no user, can't check payment method
        if (!$user) {
            return false;
        }

        // Check if user has at least one valid payment method
        return $user->paymentMethods()
            ->where('is_valid', true)
            ->exists();
    }

    /**
     * Hook called when entering this step.
     *
     * @param  Request  $request  The current request
     */
    public function onEnter(Request $request): void
    {
        // Optional: Log payment method check entry
    }

    /**
     * Hook called when exiting this step.
     *
     * @param  Request  $request  The current request
     */
    public function onExit(Request $request): void
    {
        // Optional: Log payment method check exit
    }

    /**
     * Hook called when this guard passes (payment method exists).
     *
     * @param  Request  $request  The current request
     */
    public function onPass(Request $request): void
    {
        // Optional: Log that payment method exists
    }

    /**
     * Hook called when this guard fails (payment method needed).
     *
     * @param  Request  $request  The current request
     */
    public function onFail(Request $request): void
    {
        // Optional: Log that payment method is needed
    }
}
