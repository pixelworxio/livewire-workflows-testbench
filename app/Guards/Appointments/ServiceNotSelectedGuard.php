<?php

namespace App\Guards\Appointments;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

/**
 * Guard that checks if a service has been selected.
 *
 * Returns true if service_id exists in session (step should be SKIPPED)
 * Returns false if service_id does not exist (step should be EXECUTED)
 */
class ServiceNotSelectedGuard implements GuardContract
{
    /**
     * Determine if the step should be skipped.
     *
     * @param Request $request
     * @return bool True if guard passes (skip step), false if guard fails (execute step)
     */
    public function passes(Request $request): bool
    {
        // Skip this step if a service is already selected
        $serviceId = workflowState('book-appointment')
            ->forRequest($request)
            ->get('service_id');

        return ! is_null($serviceId);
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
