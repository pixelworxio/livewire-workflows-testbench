<?php

namespace App\Http\Controllers\Checkout;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Invokable controller for the shipping step in checkout workflow.
 *
 * This demonstrates using a traditional controller instead of Livewire component
 * as a workflow step, showcasing the package's flexibility.
 */
class ShippingController
{
    /**
     * Display the shipping address form.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        // Handle form submission
        if ($request->isMethod('post')) {
            return $this->handleShippingSubmission($request);
        }

        // Pre-populate shipping address if already in session
        $shippingAddress = session('checkout_shipping_address', [
            'full_name' => '',
            'address_line_1' => '',
            'address_line_2' => '',
            'city' => '',
            'state' => '',
            'zip_code' => '',
            'country' => 'US',
        ]);

        return view('checkout.shipping', compact('shippingAddress'));
    }

    /**
     * Handle shipping address form submission.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handleShippingSubmission(Request $request)
    {
        // Validate shipping address
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:50',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:2',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Store shipping address in session
        session()->put('checkout_shipping_address', [
            'full_name' => $request->input('full_name'),
            'address_line_1' => $request->input('address_line_1'),
            'address_line_2' => $request->input('address_line_2'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'zip_code' => $request->input('zip_code'),
            'country' => $request->input('country'),
        ]);

        // Continue to next workflow step
        return continueWorkflow($request, 'checkout');
    }
}
