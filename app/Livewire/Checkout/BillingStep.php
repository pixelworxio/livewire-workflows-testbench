<?php

namespace App\Livewire\Checkout;

use App\Livewire\Traits\CheckoutProperties;
use App\Livewire\Traits\HasAddress;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\{WorkflowState,WorkflowStep};
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

#[WorkflowStep(flow:'checkout', key:'billing', middleware: ['web', 'auth'])]
class BillingStep extends Component
{
    use CheckoutProperties;
    use HasAddress;
    use InteractsWithWorkflows;

    /**
     * Validation rules for billing address.
     */
    protected function rules(): array
    {
        return [
            'billing_address.full_name' => 'required|string|max:255',
            'billing_address.address_line_1' => 'required|string|max:255',
            'billing_address.address_line_2' => 'nullable|string|max:255',
            'billing_address.city' => 'required|string|max:100',
            'billing_address.state' => 'required|string|max:50',
            'billing_address.zip_code' => 'required|string|max:20',
            'billing_address.country' => 'required|string|max:2',
        ];
    }

    /**
     * Toggle same as shipping.
     */
    public function updatedSameAsShipping($value): void
    {
        if ($value && !empty($this->shipping_address)) {
            $this->billing_address = $this->shipping_address;
        }
    }

    /**
     * Save billing address and continue.
     */
    public function saveBillingAddress(): void
    {
        // Validate input
        $this->validate();

        // Continue to next step
        $this->continue('checkout');
    }

    /**
     * Go back to previous step.
     */
    public function goBack(): void
    {
        $this->reset('billing_address','same_as_shipping');

        $this->back('checkout', 'billing');
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.checkout.billing-step')->layout('layouts.app');
    }
}
