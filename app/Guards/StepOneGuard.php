<?php

namespace App\Guards;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

class StepOneGuard implements GuardContract
{
    public function passes(Request $request): bool
    {
        if ($request->session()->has('testProperty1')) {
//        if ($request->session()->has('test-continue-one')) {
            return true;
        }

//        dd('not found', $request);
        return false;
    }

    public function onEnter(Request $request): void {}
    public function onExit(Request $request): void {}
    public function onPass(Request $request): void {}
    public function onFail(Request $request): void {}
}
