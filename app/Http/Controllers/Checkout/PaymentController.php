<?php

namespace App\Http\Controllers\Checkout;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Invokable controller for the payment method step in checkout workflow.
 *
 * This demonstrates using a traditional controller instead of Livewire component
 * as a workflow step, showcasing the package's flexibility.
 */
class PaymentController
{
    /**
     * Display the payment method selection form.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        // Handle form submission
        if ($request->isMethod('post')) {
            return $this->handlePaymentSubmission($request);
        }

        // Pre-populate payment method if already in session
        $paymentMethod = session('checkout_payment_method', '');

        // Available payment methods
        $paymentMethods = [
            'credit_card' => 'Credit Card',
            'debit_card' => 'Debit Card',
            'paypal' => 'PayPal',
            'stripe' => 'Stripe',
            'bank_transfer' => 'Bank Transfer',
        ];

        return view('checkout.payment', compact('paymentMethod', 'paymentMethods'));
    }

    /**
     * Handle payment method form submission.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handlePaymentSubmission(Request $request)
    {
        // Validate payment method
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|string|in:credit_card,debit_card,paypal,stripe,bank_transfer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Store payment method in session
        session()->put('checkout_payment_method', $request->input('payment_method'));

        // Continue to next workflow step
        return continueWorkflow($request, 'checkout');
    }
}
