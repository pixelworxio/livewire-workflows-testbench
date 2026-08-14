<?php

declare(strict_types=1);

namespace App\Guards\Checkout;

use App\Models\Order;
use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

class OrderNotConfirmedGuard implements GuardContract
{
    /**
     * Determine if the guard passes.
     *
     * @param  Request  $request  The current request
     * @return bool True if the step can be skipped, false if the step should be shown
     */
    public function passes(Request $request): bool
    {
        $orderNumber = workflowState('checkout')
            ->forRequest($request)
            ->get('checkout.order.order_number');

        $orderConfirmed = workflowState('checkout')
            ->forRequest($request)
            ->get('checkout.order.order_confirmed', false);

        if (empty($orderNumber) || ! $orderConfirmed) {
            return false;
        }

        $order_exists = Order::where('order_number', $orderNumber)->exists();

        return $order_exists && $orderConfirmed;
    }

    /**
     * Hook called when entering this step.
     *
     * @param  Request  $request  The current request
     */
    public function onEnter(Request $request): void {}

    /**
     * Hook called when exiting this step.
     *
     * @param  Request  $request  The current request
     */
    public function onExit(Request $request): void {}

    /**
     * Hook called when this step passes.
     *
     * @param  Request  $request  The current request
     */
    public function onPass(Request $request): void {}

    /**
     * Hook called when this step fails.
     *
     * @param  Request  $request  The current request
     */
    public function onFail(Request $request): void {}
}
