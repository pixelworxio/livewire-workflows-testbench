<?php

declare(strict_types=1);

namespace App\Guards\Registration;

use App\Models\User;
use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

class DemographicsNotCompletedGuard implements GuardContract
{
    /**
     * Determine if the guard passes.
     *
     * @param  Request  $request  The current request
     * @return bool True if the step can be skipped, false if the step should be shown
     */
    public function passes(Request $request): bool
    {
        $state = workflowState('register')->forRequest($request);
        $age = $state->get('registration.age');
        $location = $state->get('registration.location');
        $phone = $state->get('registration.phone');
        $email = $state->get('registration.email');

        if ($age === null || $location === null || $phone === null || $email === null) {
            return false;
        }

        return User::whereEmail($email)
            ->whereAge($age)
            ->whereLocation($location)
            ->wherePhone($phone)
            ->exists();
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
