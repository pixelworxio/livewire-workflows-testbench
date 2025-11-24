<?php

namespace App\Guards\Appointments;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

/**
 * Guard that checks if a provider has been selected.
 *
 * Returns true if provider_id exists in session (step should be SKIPPED)
 * Returns false if provider_id does not exist (step should be EXECUTED)
 */
class ProviderNotSelectedGuard implements GuardContract
{
    /**
     * Determine if the step should be skipped.
     *
     * @param Request $request
     * @return bool True if guard passes (skip step), false if guard fails (execute step)
     */
    public function passes(Request $request): bool
    {
        // Skip this step if a provider is already selected
        $provider_id = workflowState('book-appointment')
            ->forRequest($request)
            ->get('provider_id');

        return ! is_null($provider_id);
    }

    /**
     * Called when workflow enters this step.
     */
    public function onEnter(Request $request): void
    {
        // Optional: Log entry, analytics, etc.
    }

    /**
     * Called when workflow exits this step.
     */
    public function onExit(Request $request): void
    {
        // Optional: Cleanup, logging, etc.
    }

    /**
     * Called when guard passes (step will be skipped).
     */
    public function onPass(Request $request): void
    {
        // Optional: Log skip reason, analytics, etc.
    }

    /**
     * Called when guard fails (step will be executed).
     */
    public function onFail(Request $request): void
    {
        // Optional: Log execution, analytics, etc.
    }
}
