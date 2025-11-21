<?php

namespace App\Livewire\Registration;

use App\Models\Business;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class SubscriptionStep extends Component
{
    use InteractsWithWorkflows;

    #[WorkflowState]
    public string $subscription_plan = '';

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

            // Create Business
            $business = Business::create([
                'name' => session('registration.business_name'),
                'business_type' => session('registration.business_type'),
            ]);

            // Create User
            $user = User::create([
                'email' => session('registration.email'),
                'password' => Hash::make(session('registration.password')),
                'business_id' => $business->id,
                'age' => session('registration.age'),
                'location' => session('registration.location'),
                'phone' => session('registration.phone'),
                'name' => session('registration.email'), // Use email as name for now
            ]);

            // Create Subscription
            Subscription::create([
                'business_id' => $business->id,
                'plan_type' => $this->subscription_plan,
                'status' => 'active',
                'expires_at' => now()->addYear(),
            ]);

            DB::commit();

            // Store subscription plan in session for guard check
            session()->put('registration.subscription_plan', $this->subscription_plan);

            // Continue workflow (redirects to exit point)
            $this->continue('register');

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
        $this->back('register', 'subscription');
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
