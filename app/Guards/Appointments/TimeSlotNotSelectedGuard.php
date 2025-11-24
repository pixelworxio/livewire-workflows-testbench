<?php

namespace App\Guards\Appointments;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

/**
 * Guard that checks if a time slot has been selected.
 *
 * Returns true if scheduled_at exists in session (step should be SKIPPED)
 * Returns false if scheduled_at does not exist (step should be EXECUTED)
 */
class TimeSlotNotSelectedGuard implements GuardContract
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
        $scheduled_at = workflowState('book-appointment')
            ->forRequest($request)
            ->get('scheduled_at');

        return ! is_null($scheduled_at);
    }

    /**
     * Called when workflow enters this step.
     */
    public function onEnter(Request $request): void
    {
        \Log::info('TimeSlotNotSelectedGuard entered', [
            'state' => workflowState('book-appointment')->forRequest($request)->all(),
        ]);
    }

    /**
     * Called when workflow exits this step.
     */
    public function onExit(Request $request): void
    {
        \Log::info('TimeSlotNotSelectedGuard exited', [
            'state' => workflowState('book-appointment')->forRequest($request)->all(),
        ]);
    }

    /**
     * Called when guard passes (step will be skipped).
     */
    public function onPass(Request $request): void
    {
        \Log::info('TimeSlotNotSelectedGuard passed', [
            'state' => workflowState('book-appointment')->forRequest($request)->all(),
        ]);
    }

    /**
     * Called when guard fails (step will be executed).
     */
    public function onFail(Request $request): void
    {
        \Log::info('TimeSlotNotSelectedGuard failed', [
            'state' => workflowState('book-appointment')->forRequest($request)->all(),
        ]);
    }
}
