<?php

namespace App\Livewire\Registration;

use App\Models\{Business,Subscription,User};
use Illuminate\Support\Facades\{DB,Hash};
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\{WorkflowState,WorkflowStep};
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

#[WorkflowStep(flow:'register', key: 'subscription')]
class SubscriptionStep extends Component
{
    use InteractsWithWorkflows;

    #[WorkflowState(namespace:'registration')]
    public string $business_id = '';

    #[WorkflowState(namespace: 'registration')]
    public ?string $email = '';

    #[WorkflowState(namespace: 'registration')]
    public string $subscription_plan = '';

    #[WorkflowState(namespace: 'registration')]
    public string $subscription_id = '';

    /**
     * Available subscription plans.
     */
    public array $plans = [
        'basic' => [
            'name' => 'Basic',
            'price' => 99,
            'features' => [
                'Up to 10 users',
                'Basic reporting',
                'Email support',
                '5 GB storage',
            ],
        ],
        'premium' => [
            'name' => 'Premium',
            'price' => 199,
            'features' => [
                'Unlimited users',
                'Advanced reporting & analytics',
                'Priority phone & email support',
                'Unlimited storage',
                'Custom integrations',
            ],
        ],
    ];

    /**
     * Validation rules for this step.
     */
    protected function rules(): array
    {
        return [
            'subscription_plan' => 'required|in:basic,premium',
        ];
    }

    /**
     * Select a subscription plan.
     */
    public function selectPlan(string $plan): void
    {
        $this->subscription_plan = $plan;
    }

    /**
     * Complete registration and create all records.
     */
    public function completeRegistration(): void
    {
        // Validate input
        $this->validate();

        try {
            DB::beginTransaction();

            // Create Subscription
            $new_subscription = Subscription::create([
                'business_id' => Business::find($this->business_id)->id,
                'plan_type' => $this->subscription_plan,
                'status' => 'active',
                'expires_at' => now()->addYear(),
            ]);

            DB::commit();

            $this->subscription_id = $new_subscription->id;

            // Continue workflow (redirects to exit point)
            $this->continue();

        } catch (\Exception $e) {

            DB::rollBack();

            // Show error message
            $this->addError('registration', 'Registration failed. Please try again. '.$e->getMessage());
        }
    }

    /**
     * Go back to previous step.
     */
    public function goBack(): void
    {
        $this->back();
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.registration.subscription-step')
            ->layout('layouts.guest');
    }
}
