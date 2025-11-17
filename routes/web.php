<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::view('/', 'welcome')->name('index');

Route::get('/continue-test-workflow', function (Request $request) {
    session()->put('testProperty1', $request->attributes->all());
    return continueWorkflow($request, 'test2');
})->name('continue-test-workflow');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('appointment-confirmed', 'appointments.confirmed')
    ->middleware(['auth'])
    ->name('appointment.confirmed');

Route::view('order-confirmed', 'order.confirmed')
    ->middleware(['auth'])
    ->name('order.confirmed');

require __DIR__.'/auth.php';
