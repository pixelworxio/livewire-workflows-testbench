<?php

namespace App\Guards;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

class StepTwoGuard implements GuardContract
{
    public function passes(Request $request): bool
    {
        if ($request->session()->has('test-continue-two')) {
            return true;
        }

        return false;
    }

    public function onEnter(Request $request): void {}
    public function onExit(Request $request): void {}
    public function onPass(Request $request): void {}
    public function onFail(Request $request): void {
        \Log::error('Failing request', [$request]);
    }
}
