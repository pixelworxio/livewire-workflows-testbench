<?php

use App\Livewire\ParameterizedRoutes\StepOne;
use App\Livewire\ParameterizedRoutes\StepThree;
use App\Livewire\ParameterizedRoutes\StepTwo;
use Pixelworxio\LivewireWorkflows\Facades\Workflow;

/*
|--------------------------------------------------------------------------
| Workflow Routes
|--------------------------------------------------------------------------
|
| Define your multi-step workflows here using the readable DSL.
| Each workflow automatically registers its entry and step routes.
|
| Example:
|
| Workflow::flow('onboarding')
|     ->entersAt(name: 'onboarding.start', path: '/onboarding')
|     ->finishesAt('dashboard')
|     ->historyMode('stack')
|     ->step('verify-email')
|         ->goTo(\App\Livewire\Onboarding\VerifyEmail::class)
|         ->unlessPasses(\App\Guards\EmailVerifiedGuard::class)
|         ->order(10)
|     ->step('profile')
|         ->goTo(\App\Livewire\Onboarding\EditProfile::class)
|         ->unlessPasses(\App\Guards\ProfileCompletedGuard::class)
|         ->order(20);
|
*/

Workflow::flow('test-flow')
    ->entersAt(name: 'test-flow.start', path: '/test-flow')
    ->finishesAt('index')
    ->step('step-one')
        ->goTo(\App\Livewire\StepOneComponent::class)
        ->unlessPasses(\App\Guards\StepOneGuard::class)
        ->order(10)
    ->step('step-two')
        ->goTo(\App\Livewire\StepTwoComponent::class)
        ->unlessPasses(\App\Guards\StepTwoGuard::class)
        ->order(20)
    ->step('step-three')
        ->goTo(\App\Livewire\StepThreeComponent::class)
        ->unlessPasses(\App\Guards\StepThreeGuard::class)
        ->order(30);

// Parameterized Routes w/ Invokable Controllers as Steps
Workflow::flow('parameterized-routes')
    ->entersAt(name: 'parameterized.start', path: '/parameterized/{testModel}/user/{user}')
    ->finishesAt('index')
    ->step('first-one')
        ->goTo(StepOne::class)
        ->unlessPasses(\App\Guards\StepOneGuard::class)
        ->order(10)
    ->step('second-one')
        ->goTo(StepTwo::class)
        ->unlessPasses(\App\Guards\StepTwoGuard::class)
        ->order(20)
    ->step('third-one')
        ->goTo(StepThree::class)
        ->unlessPasses(\App\Guards\StepThreeGuard::class)
        ->order(30);

// Parameterized Routes w/ Invokable Controllers as Steps
//Workflow::flow('test2')
//    ->entersAt(name: 'test2-flow.start', path: '/test2/{testModel}/user/{user}')
//    ->finishesAt('index')
//    ->step('first-one')
//        ->goTo(\App\Http\Controllers\Workflows\StepOneController::class)
//        ->unlessPasses(\App\Guards\StepOneGuard::class)
//        ->order(10)
//    ->step('second-one')
//        ->goTo(\App\Http\Controllers\Workflows\StepTwoController::class)
//        ->unlessPasses(\App\Guards\StepTwoGuard::class)
//        ->order(20);

// Login Flow
Workflow::flow('login')
    ->entersAt(name: 'login.test', path: '/auth')
    ->finishesAt('dashboard')
    ->step('login')
        ->goTo(\App\Livewire\Auth\TestLoginComponent::class)
        ->unlessPasses(\App\Guards\Auth\TestLoginGuard::class)
        ->order(10)
    ->step('mfa')
        ->goTo(\App\Livewire\Auth\TestMfaComponent::class)
        ->unlessPasses(\App\Guards\Auth\TestMultiFactorGuard::class)
        ->order(20)
    ->step('subscribe')
        ->goTo(\App\Livewire\Auth\TestSubscribeComponent::class)
        ->unlessPasses(\App\Guards\Auth\TestAlreadySubscribedGuard::class)
        ->order(30);
