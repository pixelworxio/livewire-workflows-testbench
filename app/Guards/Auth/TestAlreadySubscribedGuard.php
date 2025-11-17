<?php

declare(strict_types=1);

namespace App\Guards\Auth;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

class TestAlreadySubscribedGuard implements GuardContract
{
    /**
     * Determine if the guard passes.
     *
     * @param  Request  $request  The current request
     * @return bool True if the step can be skipped, false if the step should be shown
     */
    public function passes(Request $request): bool
    {
        return true;
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
