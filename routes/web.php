<?php

use App\Livewire\Checkout\ViewOrders;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Livewire\Appointments\ViewAppointments;

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

Route::get('/book-another-meeting',
    function (Request $request) {
        workflowState('book-appointment')->forRequest($request)->clear(); // clear the workflow state for this user
        return redirect()->route('appointment.start');
    })
    ->middleware(['auth'])
    ->name('appointment.book-again');

Route::view('order-confirmed', 'order.confirmed')
    ->middleware(['auth'])
    ->name('order.confirmed');

Route::get('/appointments', ViewAppointments::class)
    ->middleware(['auth'])
    ->name('appointments.index');

Route::get('/orders', ViewOrders::class)
    ->middleware(['auth'])
    ->name('orders.index');

require __DIR__.'/auth.php';
