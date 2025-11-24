<?php

namespace App\Guards\Appointments;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

/**
 * Guard that checks if a time slot has been selected.
 *
 * Returns true if scheduled_at exists in session (step should be SKIPPED)
 * Returns false if scheduled_at does not exist (step should be EXECUTED)
 */
class TimeSlotNotConfirmedGuard implements GuardContract
{
    /**
     * Determine if the step should be skipped.
     *
     * @param Request $request
     * @return bool True if guard passes (skip step), false if guard fails (execute step)
     */
    public function passes(Request $request): bool
    {
        // Skip this step if already confirmed
        $state = workflowState('book-appointment')
            ->forRequest($request)
            ->all();

//        dd(
//            $state,
//            Appointment::where('service_id', $state['service_id'])
//                ->where('provider_id', $state['provider_id'])
//                ->where('scheduled_at', $state['scheduled_at'])
//                ->first(),
//            Appointment::where('user_id', auth()->id())
//                ->where('service_id', $state['service_id'])
//                ->where('provider_id', $state['provider_id'])
//                ->where('scheduled_at', $state['scheduled_at'])
//                ->first()
//        );

        $appt_created = Appointment::where('user_id', auth()->id())
            ->where('service_id', $state['service_id'])
            ->where('provider_id', $state['provider_id'])
            ->where('scheduled_at', $state['scheduled_at'])
            ->first();

//        session()->set('appointment_id', $appt_created->id);

        return ! is_null($state['confirmed'] ?? null) && $appt_created;
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
