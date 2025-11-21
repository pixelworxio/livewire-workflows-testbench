# CLAUDE.md - Livewire Workflows Testbench

## Overview

This repository serves as a **testbench and reference implementation** for the [pixelworxio/livewire-workflows](https://github.com/pixelworxio/livewire-workflows) package. It provides complete, production-ready workflow examples that demonstrate best practices for building multi-step processes in Laravel using Livewire 3.

### Purpose

- **Testbench Environment**: A fully functional Laravel 12 application for testing and developing workflow features
- **Documentation by Example**: Complete workflow implementations that serve as living documentation
- **Medium Article Companion**: Enhanced code examples that accompany Medium articles, with improved implementations
- **Best Practices Showcase**: Demonstrates SOLID, DRY, and KISS principles in workflow architecture

---

## Architecture Principles

This testbench adheres to three core software design principles:

### 1. SOLID Principles

- **Single Responsibility**: Each component, guard, and class has one clear purpose
  - Guards only handle step eligibility logic
  - Components only manage their step's UI and user interaction
  - Models represent single domain entities

- **Open/Closed**: Workflows are open for extension but closed for modification
  - New steps can be added without changing existing ones
  - Guards can be composed and reused across workflows

- **Liskov Substitution**: All guards implement `GuardContract`
  - Any guard can be swapped for another without breaking the workflow
  - Guards are interchangeable and predictable

- **Interface Segregation**: Small, focused contracts
  - `GuardContract` defines minimal required methods
  - `InteractsWithWorkflows` trait provides opt-in functionality

- **Dependency Inversion**: Depend on abstractions, not concretions
  - Workflows depend on `GuardContract`, not specific guard implementations
  - Components use trait-based capabilities rather than inheritance

### 2. DRY (Don't Repeat Yourself)

- **Reusable Guards**: Common conditions (authentication, authorization) are extracted into shared guards
- **Blade Components**: UI elements (`x-primary-button`, `x-text-input`) are componentized
- **Traits**: `InteractsWithWorkflows` provides common workflow behavior to all components
- **Layouts**: `app.blade.php` and `guest.blade.php` avoid repeating HTML structure

### 3. KISS (Keep It Simple, Stupid)

- **Clear Naming**: Components, guards, and routes use descriptive, self-documenting names
- **Minimal Abstractions**: Only abstract what needs to vary
- **Straightforward Flow**: Workflows read linearly from entry to finish
- **Explicit State**: Workflow state is visible and manageable (session-based by default)

---

## Repository Structure

```
livewire-workflows-testbench/
├── app/
│   ├── Guards/                    # Workflow step guards
│   │   ├── Auth/                  # Authentication-specific guards
│   │   │   ├── TestLoginGuard.php
│   │   │   ├── TestAlreadySubscribedGuard.php
│   │   │   └── TestMultiFactorGuard.php
│   │   ├── StepOneGuard.php
│   │   ├── StepTwoGuard.php
│   │   └── StepThreeGuard.php
│   ├── Livewire/                  # Livewire step components
│   │   ├── StepOneComponent.php
│   │   ├── StepTwoComponent.php
│   │   ├── StepThreeComponent.php
│   │   ├── ParameterizedRoutes/   # Components with route parameters
│   │   │   ├── StepOne.php
│   │   │   ├── StepTwo.php
│   │   │   └── StepThree.php
│   │   └── Auth/                  # Authentication workflow components
│   │       ├── TestLoginComponent.php
│   │       ├── TestMfaComponent.php
│   │       └── TestSubscribeComponent.php
│   └── Models/
│       ├── User.php
│       └── TestModel.php
├── config/
│   └── livewire-workflows.php    # Workflow configuration
├── database/
│   ├── migrations/
│   │   └── create_test_models_table.php
│   └── factories/
│       ├── UserFactory.php
│       └── TestModelFactory.php
├── resources/
│   └── views/
│       ├── livewire/              # Step component views
│       │   ├── step-one-component.blade.php
│       │   ├── step-two-component.blade.php
│       │   ├── step-three-component.blade.php
│       │   ├── auth/              # Auth workflow views
│       │   │   ├── test-login-component.blade.php
│       │   │   ├── test-mfa-component.blade.php
│       │   │   └── test-subscribe-component.blade.php
│       │   └── parameterized-routes/
│       │       ├── step-one.blade.php
│       │       ├── step-two.blade.php
│       │       └── step-three.blade.php
│       ├── layouts/
│       │   ├── app.blade.php      # Authenticated layout
│       │   └── guest.blade.php    # Guest layout
│       └── components/            # Reusable Blade components
├── routes/
│   ├── workflows.php              # Workflow definitions (PRIMARY FILE)
│   └── web.php                    # Standard web routes
└── tests/
    ├── Feature/                   # Feature tests for workflows
    └── Unit/                      # Unit tests for components/guards
```

---

## Existing Workflow Examples

### 1. Simple Multi-Step Workflow (`test-flow`)

**Location**: `routes/workflows.php` (line ~8)

**Purpose**: Demonstrates basic sequential workflow with guards

**Components**:
- `app/Livewire/StepOneComponent.php`
- `app/Livewire/StepTwoComponent.php`
- `app/Livewire/StepThreeComponent.php`

**Guards**:
- `app/Guards/StepOneGuard.php` - Checks session for 'testProperty1'
- `app/Guards/StepTwoGuard.php` - Checks session for 'testProperty2'
- `app/Guards/StepThreeGuard.php` - Checks session for 'testProperty3'

**Views**:
- `resources/views/livewire/step-one-component.blade.php`
- `resources/views/livewire/step-two-component.blade.php`
- `resources/views/livewire/step-three-component.blade.php`

**Entry Point**: `/test-flow`
**Exit Point**: `index` route (home page)

**Key Features**:
- Session-based state persistence
- Guard-controlled step progression
- Simple form input at each step

---

### 2. Parameterized Routes Workflow (`parameterized-routes`)

**Location**: `routes/workflows.php` (line ~28)

**Purpose**: Demonstrates workflow with route model binding

**Components**:
- `app/Livewire/ParameterizedRoutes/StepOne.php`
- `app/Livewire/ParameterizedRoutes/StepTwo.php`
- `app/Livewire/ParameterizedRoutes/StepThree.php`

**Guards**:
- Uses same guards as simple workflow (reusable!)

**Views**:
- `resources/views/livewire/parameterized-routes/step-one.blade.php`
- `resources/views/livewire/parameterized-routes/step-two.blade.php`
- `resources/views/livewire/parameterized-routes/step-three.blade.php`

**Entry Point**: `/parameterized/{testModel}/user/{user}`
**Exit Point**: `index` route

**Key Features**:
- Route parameters automatically inject Eloquent models
- Demonstrates model binding in workflow context
- Models passed through entire workflow via session

---

### 3. Authentication Workflow (`login`)

**Location**: `routes/workflows.php` (line ~48)

**Purpose**: Real-world authentication flow with MFA and subscription check

**Components**:
- `app/Livewire/Auth/TestLoginComponent.php` - Email/password login
- `app/Livewire/Auth/TestMfaComponent.php` - Multi-factor authentication
- `app/Livewire/Auth/TestSubscribeComponent.php` - Subscription verification

**Guards**:
- `app/Guards/Auth/TestLoginGuard.php` - Checks if user is authenticated
- `app/Guards/Auth/TestMultiFactorGuard.php` - Checks if MFA is completed
- `app/Guards/Auth/TestAlreadySubscribedGuard.php` - Checks subscription status

**Views**:
- `resources/views/livewire/auth/test-login-component.blade.php`
- `resources/views/livewire/auth/test-mfa-component.blade.php`
- `resources/views/livewire/auth/test-subscribe-component.blade.php`

**Entry Point**: `/auth`
**Exit Point**: `dashboard` route

**Key Features**:
- Conditional step execution (skip if already authenticated)
- Form validation with Livewire
- Real authentication using Laravel's Auth system
- Demonstrates skipping steps when guard passes

---

## Anatomy of a Workflow Example

Each complete workflow example should contain:

### 1. Workflow Definition (routes/workflows.php)

```php
Workflow::flow('workflow-name')
    ->entersAt(name: 'route.name', path: '/workflow-path')
    ->finishesAt('exit-route-name')
    ->step('step-identifier')
        ->goTo(\App\Livewire\StepComponent::class)
        ->unlessPasses(\App\Guards\StepGuard::class)
        ->order(10)
    ->step('next-step')
        ->goTo(\App\Livewire\NextStepComponent::class)
        ->unlessPasses(\App\Guards\NextStepGuard::class)
        ->order(20);
```

**Requirements**:
- Unique workflow name (kebab-case)
- Named route for entry point
- Exit route (where workflow completes)
- Steps with clear identifiers
- Ordered steps (use increments of 10 for easy insertion)

---

### 2. Guard Classes (app/Guards/)

```php
<?php

namespace App\Guards;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

class ExampleGuard implements GuardContract
{
    /**
     * Determine if the step should be skipped.
     *
     * @param Request $request
     * @return bool True if guard passes (skip step), false if guard fails (execute step)
     */
    public function passes(Request $request): bool
    {
        // Return true if the step should be SKIPPED
        // Return false if the step should be EXECUTED
        return false;
    }

    /**
     * Called when workflow enters this step.
     */
    public function onEnter(Request $request): void
    {
        // Optional: Log entry, initialize state, etc.
    }

    /**
     * Called when workflow exits this step.
     */
    public function onExit(Request $request): void
    {
        // Optional: Cleanup, logging, etc.
    }

    /**
     * Called when guard passes (step will be skipped).
     */
    public function onPass(Request $request): void
    {
        // Optional: Log skip reason, analytics, etc.
    }

    /**
     * Called when guard fails (step will be executed).
     */
    public function onFail(Request $request): void
    {
        // Optional: Log execution, analytics, etc.
    }
}
```

**Best Practices**:
- **Single Responsibility**: Each guard checks ONE condition
- **Descriptive Names**: Guard name should describe what it checks (e.g., `UserIsAuthenticatedGuard`)
- **Stateless**: Guards should not maintain state; read from request/session/database
- **Reusable**: Design guards to be used across multiple workflows
- **Group by Domain**: Place related guards in subdirectories (e.g., `app/Guards/Auth/`)

---

### 3. Livewire Components (app/Livewire/)

```php
<?php

namespace App\Livewire;

use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Concerns\InteractsWithWorkflows;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;

class ExampleStepComponent extends Component
{
    use InteractsWithWorkflows;

    /**
     * Properties with #[WorkflowState] are persisted across steps.
     */
    #[WorkflowState]
    public string $name = '';

    #[WorkflowState]
    public string $email = '';

    /**
     * Regular properties (without attribute) are NOT persisted.
     */
    public bool $showForm = true;

    /**
     * Validation rules for this step.
     */
    protected function rules(): array
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email',
        ];
    }

    /**
     * Process step and continue to next.
     */
    public function goToNextStep(): void
    {
        // Validate input
        $this->validate();

        // Store data in session (for guard checks)
        session()->put('step_completed', true);

        // Continue workflow (moves to next step)
        $this->continue('workflow-name');
    }

    /**
     * Go back to previous step.
     */
    public function goBack(): void
    {
        $this->back('workflow-name', 'current-step-name');
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.example-step-component')
            ->layout('layouts.guest'); // or 'layouts.app'
    }
}
```

**Best Practices**:
- **Use `#[WorkflowState]`**: Mark properties that should persist across steps
- **Validate Input**: Use Livewire validation before continuing
- **Clear Method Names**: `goToNextStep()`, `submitForm()`, `processPayment()`, etc.
- **Layout Selection**: Use `layouts.guest` for unauthenticated flows, `layouts.app` for authenticated
- **Error Handling**: Catch exceptions and display user-friendly messages
- **Group by Domain**: Place related components in subdirectories

---

### 4. Blade Views (resources/views/livewire/)

```blade
<div id="exampleStepWrapper" class="max-w-xl mx-auto">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-6">Step Title</h2>

        <!-- Form fields -->
        <div class="mb-4">
            <x-input-label for="name" value="Name" />
            <x-text-input
                id="name"
                wire:model="name"
                type="text"
                class="mt-1 block w-full"
                required
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-input-label for="email" value="Email" />
            <x-text-input
                id="email"
                wire:model="email"
                type="email"
                class="mt-1 block w-full"
                required
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Navigation buttons -->
        <div class="flex justify-between items-center">
            <x-secondary-button wire:click="goBack">
                Back
            </x-secondary-button>

            <x-primary-button wire:click="goToNextStep">
                Continue
            </x-primary-button>
        </div>
    </div>
</div>
```

**Best Practices**:
- **Use Blade Components**: Leverage `x-primary-button`, `x-text-input`, etc.
- **Wire Model**: Bind inputs with `wire:model` for reactivity
- **Show Errors**: Display validation errors with `x-input-error`
- **Consistent Styling**: Use Tailwind utility classes
- **Accessibility**: Include labels, ARIA attributes, proper form structure
- **Unique IDs**: Use unique element IDs for testing/debugging

---

## Adding a New Workflow Example

Follow these steps to add a complete workflow example:

### Step 1: Plan Your Workflow

**Example**: Creating an "Order Checkout" workflow for a Medium article

**Steps**:
1. Cart Review - Display cart contents
2. Shipping Information - Collect address
3. Payment Method - Select payment type
4. Order Confirmation - Show summary and confirm

### Step 2: Create Guards

```bash
# Create guard directory
mkdir -p app/Guards/Checkout

# Create guard files
touch app/Guards/Checkout/CartNotEmptyGuard.php
touch app/Guards/Checkout/ShippingInfoProvidedGuard.php
touch app/Guards/Checkout/PaymentMethodSelectedGuard.php
```

Implement each guard with clear `passes()` logic:

```php
// app/Guards/Checkout/CartNotEmptyGuard.php
<?php

namespace App\Guards\Checkout;

use Illuminate\Http\Request;
use Pixelworxio\LivewireWorkflows\Contracts\GuardContract;

class CartNotEmptyGuard implements GuardContract
{
    public function passes(Request $request): bool
    {
        // Return true if cart review is already done (skip this step)
        return $request->session()->has('cart_reviewed');
    }

    public function onEnter(Request $request): void {}
    public function onExit(Request $request): void {}
    public function onPass(Request $request): void {}
    public function onFail(Request $request): void {}
}
```

### Step 3: Create Livewire Components

```bash
# Create component directory
mkdir -p app/Livewire/Checkout

# Create component files
php artisan make:livewire Checkout/CartReview
php artisan make:livewire Checkout/ShippingInfo
php artisan make:livewire Checkout/PaymentMethod
php artisan make:livewire Checkout/OrderConfirmation
```

Implement each component:

```php
// app/Livewire/Checkout/CartReview.php
<?php

namespace App\Livewire\Checkout;

use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Concerns\InteractsWithWorkflows;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;

class CartReview extends Component
{
    use InteractsWithWorkflows;

    #[WorkflowState]
    public array $cartItems = [];

    public function mount()
    {
        // Load cart from session or database
        $this->cartItems = session('cart', []);
    }

    public function proceedToShipping(): void
    {
        // Mark cart as reviewed
        session()->put('cart_reviewed', true);

        // Continue to next step
        $this->continue('checkout');
    }

    public function render()
    {
        return view('livewire.checkout.cart-review')
            ->layout('layouts.app');
    }
}
```

### Step 4: Create Blade Views

Create views matching your components:

```bash
# Views are auto-created by make:livewire, but you can create them manually:
touch resources/views/livewire/checkout/cart-review.blade.php
touch resources/views/livewire/checkout/shipping-info.blade.php
touch resources/views/livewire/checkout/payment-method.blade.php
touch resources/views/livewire/checkout/order-confirmation.blade.php
```

Implement each view with appropriate forms and navigation.

### Step 5: Define the Workflow

Edit `routes/workflows.php`:

```php
use App\Livewire\Checkout\CartReview;
use App\Livewire\Checkout\ShippingInfo;
use App\Livewire\Checkout\PaymentMethod;
use App\Livewire\Checkout\OrderConfirmation;
use App\Guards\Checkout\CartNotEmptyGuard;
use App\Guards\Checkout\ShippingInfoProvidedGuard;
use App\Guards\Checkout\PaymentMethodSelectedGuard;

Workflow::flow('checkout')
    ->entersAt(name: 'checkout.start', path: '/checkout')
    ->finishesAt('checkout.complete')
    ->step('cart-review')
        ->goTo(CartReview::class)
        ->unlessPasses(CartNotEmptyGuard::class)
        ->order(10)
    ->step('shipping-info')
        ->goTo(ShippingInfo::class)
        ->unlessPasses(ShippingInfoProvidedGuard::class)
        ->order(20)
    ->step('payment-method')
        ->goTo(PaymentMethod::class)
        ->unlessPasses(PaymentMethodSelectedGuard::class)
        ->order(30)
    ->step('order-confirmation')
        ->goTo(OrderConfirmation::class)
        ->order(40);
```

### Step 6: Create Supporting Routes

Add completion route in `routes/web.php`:

```php
Route::get('/checkout/complete', function () {
    return view('checkout.complete');
})->name('checkout.complete');
```

### Step 7: Write Tests

Create feature tests for the workflow:

```bash
php artisan make:test Workflows/CheckoutWorkflowTest
```

```php
<?php

namespace Tests\Feature\Workflows;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_start_checkout_workflow(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/checkout');

        $response->assertStatus(200);
        $response->assertSeeLivewire(\App\Livewire\Checkout\CartReview::class);
    }

    public function test_workflow_progresses_through_steps(): void
    {
        $user = User::factory()->create();

        // Start workflow
        $this->actingAs($user)->get('/checkout');

        // Complete cart review
        Livewire::test(\App\Livewire\Checkout\CartReview::class)
            ->call('proceedToShipping')
            ->assertRedirect();

        // Should now be on shipping info step
        $this->get('/checkout')
            ->assertSeeLivewire(\App\Livewire\Checkout\ShippingInfo::class);
    }
}
```

### Step 8: Document for Medium Article

Create a comprehensive example that includes:

1. **Context**: Why this workflow pattern is useful
2. **Complete Code**: All guards, components, views
3. **Explanations**: Why design choices were made
4. **Testing**: How to verify the workflow works
5. **Edge Cases**: How guards handle unusual situations
6. **Extensions**: How to add features (logging, analytics, webhooks)

---

## Workflow Configuration

**File**: `config/livewire-workflows.php`

### State Persistence

```php
'repository' => env('WORKFLOWS_REPOSITORY', 'session'),
```

**Options**:
- `'session'` - Store workflow state in Laravel session (default, simplest)
- `'eloquent'` - Store workflow state in database (for persistent, multi-device flows)
- `null` - No persistence (for single-request workflows)

**When to use each**:
- **Session**: Most use cases, simple flows, single-device
- **Eloquent**: Multi-device flows, audit trails, resume across sessions
- **Null**: API workflows, single-step processes

### Middleware

```php
'middleware' => ['web'],
```

Add middleware to all workflow routes:

```php
'middleware' => ['web', 'auth'], // Require authentication
'middleware' => ['web', 'throttle:60,1'], // Rate limiting
```

---

## Working with Claude Code

When working on this repository with Claude, provide context about:

### 1. Which Workflow You're Adding

```
I'm adding a "subscription-onboarding" workflow that includes:
- Plan selection step
- Payment info collection
- Account customization
- Welcome screen
```

### 2. Related Medium Article (if applicable)

```
This workflow is for the Medium article: "Building Multi-Step Onboarding with Livewire Workflows"
Article URL: [link]
```

### 3. Special Requirements

```
This workflow needs to:
- Integrate with Stripe for payment
- Send welcome email on completion
- Support both monthly and annual plans
```

### 4. Design Patterns to Follow

Always mention that this testbench follows **SOLID, DRY, and KISS** principles. Claude should:
- Keep guards single-purpose
- Reuse existing Blade components
- Avoid unnecessary abstractions
- Write clear, self-documenting code

---

## Testing Workflows

### Manual Testing

1. **Start the development server**:
```bash
php artisan serve
```

2. **Access workflow entry point**:
```
http://localhost:8000/checkout
```

3. **Navigate through steps**:
- Complete each step's requirements
- Verify guards work (try skipping steps by setting session data)
- Test back navigation
- Test validation errors

### Automated Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run specific test file
php artisan test tests/Feature/Workflows/CheckoutWorkflowTest.php
```

### Test Coverage

Each workflow should have tests for:
- ✓ Entry point accessibility
- ✓ Step progression
- ✓ Guard logic (passes/fails)
- ✓ Back navigation
- ✓ Form validation
- ✓ Completion (exit point)
- ✓ Edge cases (empty state, invalid input)

---

## Medium Article Guidelines

When creating workflow examples for Medium articles:

### 1. Start with User Story

```
"As a customer, I want to complete my purchase in clear steps
so that I don't feel overwhelmed by a single long form."
```

### 2. Show the Problem

Explain why a multi-step workflow solves the problem better than alternatives.

### 3. Provide Complete Code

Don't use ellipses (`...`) or placeholders. Every code sample should be **runnable as-is**.

**Bad Example**:
```php
public function passes(Request $request): bool
{
    // Check if user is subscribed
    // ...
}
```

**Good Example**:
```php
public function passes(Request $request): bool
{
    // Check if user is subscribed
    $user = $request->user();

    if (!$user) {
        return false;
    }

    return $user->subscriptions()
        ->where('status', 'active')
        ->exists();
}
```

### 4. Explain Design Decisions

For each guard and component, explain:
- **Why** it exists (what problem it solves)
- **How** it works (the logic)
- **When** it's appropriate (use cases)

### 5. Include Visual Aids

- Workflow diagrams (entry → step 1 → step 2 → exit)
- Screenshots of each step
- State transition diagrams

### 6. Provide Testing Examples

Show how readers can verify the workflow works:

```php
// readers can copy-paste this test
public function test_checkout_workflow_completes_successfully(): void
{
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CartReview::class)
        ->set('cartItems', [['id' => 1, 'name' => 'Product']])
        ->call('proceedToShipping')
        ->assertRedirect();

    $this->assertTrue(session()->has('cart_reviewed'));
}
```

### 7. Show Extensions

Demonstrate how to extend the workflow:

```php
// Adding analytics tracking
public function onEnter(Request $request): void
{
    Analytics::track('workflow_step_entered', [
        'workflow' => 'checkout',
        'step' => 'cart-review',
        'user_id' => $request->user()?->id,
    ]);
}
```

---

## Common Patterns

### Pattern 1: Authenticated Workflow

**Use Case**: Workflows that require logged-in users

```php
// Guard example
class UserIsAuthenticatedGuard implements GuardContract
{
    public function passes(Request $request): bool
    {
        // Skip this step if already authenticated
        return $request->user() !== null;
    }

    public function onFail(Request $request): void
    {
        // Redirect to login if not authenticated
        if (!$request->user()) {
            abort(redirect()->route('login'));
        }
    }
}
```

### Pattern 2: Conditional Steps

**Use Case**: Steps that only appear under certain conditions

```php
// Guard example
class UserNeedsMfaGuard implements GuardContract
{
    public function passes(Request $request): bool
    {
        $user = $request->user();

        // Skip MFA step if user doesn't have it enabled
        if (!$user || !$user->mfa_enabled) {
            return true;
        }

        // Skip if MFA already completed this session
        return session()->has('mfa_completed');
    }
}
```

### Pattern 3: Data Validation Between Steps

**Use Case**: Later steps depend on earlier step data

```php
// Guard example
class ShippingAddressProvidedGuard implements GuardContract
{
    public function passes(Request $request): bool
    {
        // Check if shipping address was collected in previous step
        $shippingAddress = session('shipping_address');

        return $shippingAddress !== null
            && isset($shippingAddress['street'])
            && isset($shippingAddress['city'])
            && isset($shippingAddress['zip']);
    }

    public function onFail(Request $request): void
    {
        // Redirect back to shipping step if address is missing
        // (This prevents users from skipping steps via URL manipulation)
    }
}
```

### Pattern 4: Route Parameters in Workflows

**Use Case**: Workflows that operate on specific models

```php
// Workflow definition
Workflow::flow('order-fulfillment')
    ->entersAt(name: 'fulfillment.start', path: '/orders/{order}/fulfill')
    ->finishesAt('orders.index')
    ->step('verify-inventory')
        ->goTo(VerifyInventory::class)
        ->order(10);

// Component
class VerifyInventory extends Component
{
    use InteractsWithWorkflows;

    public Order $order;

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function verifyAndContinue(): void
    {
        // Verify inventory for this specific order
        $this->order->verifyInventory();

        $this->continue('order-fulfillment');
    }
}
```

### Pattern 5: Multi-Tenant Workflows

**Use Case**: Workflows scoped to organizations/teams

```php
// Guard example
class UserBelongsToOrganizationGuard implements GuardContract
{
    public function passes(Request $request): bool
    {
        $user = $request->user();
        $organizationId = $request->route('organization');

        if (!$user || !$organizationId) {
            return false;
        }

        return $user->organizations()
            ->where('id', $organizationId)
            ->exists();
    }
}

// Workflow definition
Workflow::flow('org-onboarding')
    ->entersAt(name: 'org.onboard', path: '/organizations/{organization}/onboard')
    ->finishesAt('org.dashboard')
    ->step('verify-membership')
        ->goTo(VerifyMembership::class)
        ->unlessPasses(UserBelongsToOrganizationGuard::class)
        ->order(10);
```

---

## Troubleshooting

### Issue: Workflow loops back to first step

**Cause**: Guard's `passes()` method returns `false` when it should return `true`

**Solution**: Guards pass when step should be **skipped**. Check your logic:

```php
// WRONG - this will never skip the step
public function passes(Request $request): bool
{
    return !session()->has('step_completed'); // ❌
}

// CORRECT - skip step when completed
public function passes(Request $request): bool
{
    return session()->has('step_completed'); // ✓
}
```

### Issue: Step is skipped unexpectedly

**Cause**: Guard is passing when it shouldn't

**Solution**: Debug guard logic:

```php
public function passes(Request $request): bool
{
    $result = session()->has('step_completed');

    // Temporary debugging
    logger()->info('Guard check', [
        'guard' => static::class,
        'result' => $result,
        'session' => session()->all(),
    ]);

    return $result;
}
```

### Issue: Workflow state not persisting

**Cause**: Properties not marked with `#[WorkflowState]` attribute

**Solution**: Add attribute to properties that need persistence:

```php
// WRONG - won't persist
public string $email = '';

// CORRECT - will persist across steps
#[WorkflowState]
public string $email = '';
```

### Issue: Can't access workflow route

**Cause**: Workflow routes not registered

**Solution**: Ensure `routes/workflows.php` is loaded in `bootstrap/app.php`:

```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
    then: function () {
        Route::middleware('web')
            ->group(base_path('routes/workflows.php'));
    },
)
```

---

## Resources

### Package Documentation
- [pixelworxio/livewire-workflows GitHub](https://github.com/pixelworxio/livewire-workflows)
- Package README and documentation

### Laravel Documentation
- [Livewire 3 Docs](https://livewire.laravel.com)
- [Laravel 12 Docs](https://laravel.com/docs/12.x)
- [Laravel Testing](https://laravel.com/docs/12.x/testing)

### Design Principles
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)
- [DRY Principle](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself)
- [KISS Principle](https://en.wikipedia.org/wiki/KISS_principle)

---

## Contributing Workflow Examples

When contributing a new workflow example:

1. **Create a feature branch**:
```bash
git checkout -b example/workflow-name
```

2. **Implement complete workflow**:
   - Guards (with tests)
   - Components (with tests)
   - Views (with styling)
   - Workflow definition

3. **Write documentation**:
   - Update this CLAUDE.md with workflow description
   - Add comments explaining complex logic
   - Create README in workflow directory if needed

4. **Test thoroughly**:
```bash
php artisan test
```

5. **Commit with clear message**:
```bash
git add .
git commit -m "Add checkout workflow example with Stripe integration"
```

6. **Push and create PR**:
```bash
git push origin example/workflow-name
```

---

## Quick Reference

### Start Development Server
```bash
php artisan serve
```

### Run Tests
```bash
php artisan test
```

### Create New Workflow Components
```bash
php artisan make:livewire WorkflowName/StepName
```

### Clear Workflow State (for testing)
```bash
php artisan cache:clear
php artisan session:clear
```

### View All Routes (including workflows)
```bash
php artisan route:list --path=workflow
```

---

## Summary

This testbench repository exists to:

1. **Test** the livewire-workflows package in a real Laravel environment
2. **Demonstrate** complete, production-ready workflow implementations
3. **Educate** through comprehensive examples that follow best practices
4. **Support** Medium articles with improved, runnable code

Every workflow example should be:
- ✓ **Complete**: No placeholders or TODOs
- ✓ **Tested**: Feature tests covering happy path and edge cases
- ✓ **Documented**: Clear comments and explanations
- ✓ **Principled**: Following SOLID, DRY, and KISS
- ✓ **Practical**: Solving real-world use cases

When in doubt, look at existing examples (test-flow, parameterized-routes, login) and follow their patterns.

---

**Last Updated**: 2025-11-17
**Laravel Version**: 12.x
**Livewire Version**: 3.6.4
**Package Version**: pixelworxio/livewire-workflows@dev
