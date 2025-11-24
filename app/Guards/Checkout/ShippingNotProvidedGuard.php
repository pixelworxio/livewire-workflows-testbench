<?php

namespace App\Guards\Checkout;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

/**
 * Guard that checks if shipping address has been provided.
 *
 * Returns true if shipping address exists in session (step should be SKIPPED)
 * Returns false if shipping address is missing (step should be EXECUTED)
 */
class ShippingNotProvidedGuard implements GuardContract
{
    /**
     * Determine if the step should be skipped.
     *
     * @param Request $request
     * @return bool True if guard passes (skip step), false if guard fails (execute step)
     */
    public function passes(Request $request): bool
    {
        $shippingAddressCollected = workflowState('checkout')
            ->forRequest($request)
            ->get('checkout.shipping.shipping_address') ?? [];

        // Fail if we have an empty array
        if (empty($shippingAddressCollected)) {
            return false;
        }

        // Double-check each property for a value
        foreach ($shippingAddressCollected as $property => $value) {
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
