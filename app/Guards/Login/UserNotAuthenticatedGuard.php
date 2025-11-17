<?php

declare(strict_types=1);

namespace App\Guards\Login;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

/**
 * Guard to check if user is already authenticated.
 *
 * Returns true (passes) if user IS logged in, which skips the login step.
 * Returns false (fails) if user is NOT logged in, which executes the login step.
 */
class UserNotAuthenticatedGuard implements GuardContract
{
    /**
     * Determine if the guard passes.
     *
     * @param  Request  $request  The current request
     * @return bool True if the step can be skipped (user is logged in), false if the step should be shown
     */
    public function passes(Request $request): bool
    {
        // Skip login step if user is already authenticated
        return $request->user() !== null;
    }

    /**
     * Hook called when entering this step.
     *
     * @param  Request  $request  The current request
     */
    public function onEnter(Request $request): void
    {
        // Optional: Log when user enters login step
    }

    /**
     * Hook called when exiting this step.
     *
     * @param  Request  $request  The current request
     */
    public function onExit(Request $request): void
    {
        // Optional: Log when user exits login step
    }

    /**
     * Hook called when this guard passes (user already logged in).
     *
     * @param  Request  $request  The current request
     */
    public function onPass(Request $request): void
    {
        // Optional: Log skip reason
    }

    /**
     * Hook called when this guard fails (user needs to log in).
     *
     * @param  Request  $request  The current request
     */
    public function onFail(Request $request): void
    {
        // Optional: Log that login is required
    }
}
