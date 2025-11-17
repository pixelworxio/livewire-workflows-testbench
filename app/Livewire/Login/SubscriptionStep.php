<?php

namespace App\Livewire\Login;

use App\Models\Subscription;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class SubscriptionStep extends Component
{
    use InteractsWithWorkflows;

    /**
     * Create a subscription for the user's business and continue.
     */
    public function createSubscription(): void
    {
        $user = auth()->user();

        // Ensure user has a business
        if (!$user->business) {
            session()->flash('error', 'You must be associated with a business to create a subscription.');
            return;
        }

        // Create a basic subscription for the business
        Subscription::create([
            'business_id' => $user->business->id,
            'plan_type' => 'basic',
            'status' => 'active',
            'expires_at' => now()->addYear(),
        ]);

        // Continue to the next step in the workflow
        $this->continue('login');
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        $user = auth()->user();

        return view('livewire.login.subscription-step', [
            'businessName' => $user?->business?->name ?? 'Your Business',
        ])->layout('layouts.app');
    }
}
