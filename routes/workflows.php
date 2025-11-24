<?php

use App\Guards\Checkout\OrderNotConfirmedGuard;
use App\Livewire\Appointments\ServiceSelection;
use App\Livewire\Appointments\ProviderSelection;
use App\Livewire\Appointments\TimeSlotSelection;
use App\Livewire\Appointments\ConfirmationStep;
use App\Livewire\Checkout\CartReview;
use App\Livewire\Checkout\BillingStep;
use App\Livewire\Checkout\ConfirmationStep as CheckoutConfirmationStep;
use App\Http\Controllers\Checkout\ShippingController;
use App\Http\Controllers\Checkout\PaymentController;
use App\Guards\Appointments\ServiceNotSelectedGuard;
use App\Guards\Appointments\ProviderNotSelectedGuard;
use App\Guards\Appointments\TimeSlotNotConfirmedGuard;
use App\Guards\Appointments\TimeSlotNotSelectedGuard;
use App\Guards\Checkout\CartNotEmptyGuard;
use App\Guards\Checkout\ShippingNotProvidedGuard;
use App\Guards\Checkout\BillingNotProvidedGuard;
use App\Guards\Checkout\PaymentNotProcessedGuard;
use App\Livewire\Checkout\PaymentStep;
use App\Livewire\Checkout\Shipping;
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

/*
|--------------------------------------------------------------------------
| Registration Workflow - {url}/register-test
|--------------------------------------------------------------------------
|
| Four-step registration process for new users:
| 1. User credentials (email, password)
| 2. Business information (name, type)
| 3. Demographics (age, location, phone)
| 4. Subscription selection (basic or premium)
|
*/
// Registration Flow
Workflow::flow('register')
    ->entersAt(name: 'register.start', path: '/register-test')
    ->finishesAt('login.start')
    ->step('user')
        ->goTo(\App\Livewire\Registration\UserStep::class)
        ->unlessPasses(\App\Guards\Registration\UserNotCreatedGuard::class)
        ->order(10)
    ->step('business')
        ->goTo(\App\Livewire\Registration\BusinessStep::class)
        ->unlessPasses(\App\Guards\Registration\BusinessNotCreatedGuard::class)
        ->order(20)
    ->step('demographics')
        ->goTo(\App\Livewire\Registration\DemographicsStep::class)
        ->unlessPasses(\App\Guards\Registration\DemographicsNotCompletedGuard::class)
        ->order(30)
    ->step('subscription')
        ->goTo(\App\Livewire\Registration\SubscriptionStep::class)
        ->unlessPasses(\App\Guards\Registration\SubscriptionNotSelectedGuard::class)
        ->order(40);

/*
|--------------------------------------------------------------------------
| Login with MFA Workflow - {url}/login-test
|--------------------------------------------------------------------------
|
| Four-step login process with multi-factor authentication:
| 1. Account login (email, password)
| 2. MFA verification (if enabled)
| 3. Subscription check (create if needed)
| 4. Payment method validation (add if needed)
|
*/
// Login Flow with MFA
Workflow::flow('login')
    ->entersAt(name: 'login.start', path: '/login-test')
    ->finishesAt('dashboard')
    ->step('account')
        ->goTo(\App\Livewire\Login\AccountStep::class)
        ->unlessPasses(\App\Guards\Login\UserNotAuthenticatedGuard::class)
        ->order(10)
    ->step('mfa')
        ->goTo(\App\Livewire\Login\MfaStep::class)
        ->unlessPasses(\App\Guards\Login\MfaNotRequiredOrCompletedGuard::class)
        ->order(20)
    ->step('subscription')
        ->goTo(\App\Livewire\Login\SubscriptionStep::class)
        ->unlessPasses(\App\Guards\Login\SubscriptionExistsGuard::class)
        ->order(30)
    ->step('payment-method')
        ->goTo(\App\Livewire\Login\PaymentMethodStep::class)
        ->unlessPasses(\App\Guards\Login\PaymentMethodExistsGuard::class)
        ->order(40);

/*
|--------------------------------------------------------------------------
| Appointment Booking Workflow
|--------------------------------------------------------------------------
|
| Four-step appointment scheduling process:
| 1. Service selection
| 2. Provider selection
| 3. Time slot selection
| 4. Confirmation and booking
|
*/
// Appointment Booking Workflow
Workflow::flow('book-appointment')
    ->entersAt(name: 'appointment.start', path: '/book-appointment')
    ->finishesAt('appointment.confirmed')
    ->step('select-service')
        ->goTo(ServiceSelection::class)
        ->unlessPasses(ServiceNotSelectedGuard::class)
        ->order(10)
    ->step('select-provider')
        ->goTo(ProviderSelection::class)
        ->unlessPasses(ProviderNotSelectedGuard::class)
        ->order(20)
    ->step('select-time')
        ->goTo(TimeSlotSelection::class)
        ->unlessPasses(TimeSlotNotSelectedGuard::class)
        ->order(30)
    ->step('confirm-appointment')
        ->goTo(ConfirmationStep::class)
        ->unlessPasses(TimeSlotNotConfirmedGuard::class)
        ->order(40);

/*
|--------------------------------------------------------------------------
| Checkout Workflow
|--------------------------------------------------------------------------
|
| Five-step e-commerce checkout process.
| 1. Cart review
| 2. Shipping address
| 3. Billing address
| 4. Payment method
| 5. Order confirmation
|
*/
Workflow::flow('checkout')
    ->entersAt(name: 'checkout.start', path: '/checkout')
    ->finishesAt('order.confirmed')
    ->step('cart-review')
        ->goTo(CartReview::class)
        ->unlessPasses(CartNotEmptyGuard::class)
        ->order(10)
    ->step('shipping')
        ->goTo(Shipping::class)
        ->unlessPasses(ShippingNotProvidedGuard::class)
        ->order(20)
    ->step('billing')
        ->goTo(BillingStep::class)
        ->unlessPasses(BillingNotProvidedGuard::class)
        ->order(30)
    ->step('payment')
        ->goTo(PaymentStep::class)
        ->unlessPasses(PaymentNotProcessedGuard::class)
        ->order(40)
    ->step('confirmation')
        ->goTo(CheckoutConfirmationStep::class)
        ->unlessPasses(OrderNotConfirmedGuard::class)
        ->order(50);
