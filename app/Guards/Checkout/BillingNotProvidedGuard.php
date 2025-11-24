<?php

namespace App\Guards\Checkout;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

/**
 * Guard that checks if billing address has been provided.
 *
 * Returns true if billing address exists in session (step should be SKIPPED)
 * Returns false if billing address is missing (step should be EXECUTED)
 */
class BillingNotProvidedGuard implements GuardContract
{
    /**
     * Determine if the step should be skipped.
     *
     * @param Request $request
     * @return bool True if guard passes (skip step), false if guard fails (execute step)
     */
    public function passes(Request $request): bool
    {
        $billing_address_parts = workflowState('checkout')
            ->forRequest($request)
            ->get('checkout.billing.billing_address') ?? [];

        // Fail if we have an empty array
        if (empty($billing_address_parts)) {
            return false;
        }

        // Double-check each property for a value
        foreach ($billing_address_parts as $property => $value) {
            // Fail if we have any empty property value, other than address line 2
            if ($property !== 'address_line_2' && empty($value)) {
                return false;
            }
        }

        return true;
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
