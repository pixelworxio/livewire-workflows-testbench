<?php

namespace App\Guards\Checkout;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

/**
 * Guard that checks if the cart has items.
 *
 * Returns true if cart items exist in session (step should be SKIPPED)
 * Returns false if cart is empty (step should be EXECUTED)
 */
class CartNotEmptyGuard implements GuardContract
{
    /**
     * Determine if the step should be skipped.
     *
     * @param Request $request
     * @return bool True if guard passes (skip step), false if guard fails (execute step)
     */
    public function passes(Request $request): bool
    {
        $cart_items = workflowState('checkout')
            ->forRequest($request)
            ->get('checkout.cart.cart_items') ?? [];

        $has_items_in_cart = count($cart_items) > 0;

        $cart_confirmed = workflowState('checkout')
            ->forRequest($request)
            ->get('checkout.cart.cart_confirmed') ?? false;

        return $has_items_in_cart && $cart_confirmed;
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
