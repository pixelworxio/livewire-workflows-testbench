<?php

namespace App\Guards\Checkout;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

/**
 * Guard that checks if payment method has been selected.
 *
 * Returns true if payment method exists in session (step should be SKIPPED)
 * Returns false if payment method is missing (step should be EXECUTED)
 */
class PaymentNotProcessedGuard implements GuardContract
{
    /**
     * Determine if the step should be skipped.
     *
     * @param Request $request
     * @return bool True if guard passes (skip step), false if guard fails (execute step)
     */
    public function passes(Request $request): bool
    {
        $payment_method_selected = workflowState('checkout')
            ->forRequest($request)
            ->get('checkout.payment.selected_payment_method') ?? null;

        $payment_method_confirmed = workflowState('checkout')
            ->forRequest($request)
            ->get('checkout.payment.confirmed_payment_method') ?? false;

        return $payment_method_selected && $payment_method_confirmed;
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
