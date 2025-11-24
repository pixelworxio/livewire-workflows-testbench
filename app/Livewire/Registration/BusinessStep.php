<?php

namespace App\Livewire\Registration;

use App\Models\{Business,Subscription,User};
use Illuminate\Support\Facades\{DB,Hash};
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\{WorkflowState,WorkflowStep};
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

#[WorkflowStep(flow:'register', key: 'business')]
class BusinessStep extends Component
{
    use InteractsWithWorkflows;

    #[WorkflowState(namespace:'registration')]
    public string $business_name = '';

    #[WorkflowState(namespace:'registration')]
    public string $business_type = '';

    #[WorkflowState(namespace:'registration')]
    public string $business_id = '';

    #[WorkflowState(namespace:'registration')]
    public string $email = '';



    /**
     * Available business types.
     */
    public array $businessTypes = [
        'LLC' => 'Limited Liability Company (LLC)',
        'Corporation' => 'Corporation',
        'Sole Proprietor' => 'Sole Proprietor',
        'Partnership' => 'Partnership',
    ];

    /**
     * Validation rules for this step.
     */
    protected function rules(): array
    {
        return [
            'business_name' => 'required|min:3|max:255',
            'business_type' => 'required|in:LLC,Corporation,Sole Proprietor,Partnership',
        ];
    }

    /**
     * Process step and continue to next.
     */
    public function goToNextStep(): void
    {
        // Validate input
        $this->validate();

        try {
            DB::beginTransaction();

            // Create Business
            $business = Business::create([
                'name' => $this->business_name,
                'business_type' => $this->business_type,
            ]);

            // Create User
            $user = User::whereEmail($this->email)->update([
                'business_id' => $business->id,
            ]);

            DB::commit();

            $this->business_id = $business->id;

            // Continue workflow (redirects to exit point)
            $this->continue();

        } catch (\Exception $e) {

            DB::rollBack();

            // Show error message
            $this->addError('business_name', 'Business record creation failed. Please try again. '.$e->getMessage());
        }
    }

    /**
     * Go back to previous step.
     */
    public function goBack(): void
    {
        $this->back('register', 'business');
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.registration.business-step')
            ->layout('layouts.guest');
    }
}
