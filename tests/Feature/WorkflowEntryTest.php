<?php

namespace Tests\Feature;

use App\Guards\Registration\DemographicsNotCompletedGuard;
use App\Livewire\Checkout\ConfirmationStep as CheckoutConfirmationStep;
use App\Livewire\Registration\DemographicsStep;
use App\Livewire\Registration\UserStep;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Livewire\Livewire;
use Tests\TestCase;

class WorkflowEntryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_guest_appointment_workflow_redirects_to_and_renders_its_first_step(): void
    {
        $this->get(route('appointment.start'))
            ->assertRedirect(route('book-appointment.select-service'));

        $this->get(route('book-appointment.select-service'))
            ->assertOk()
            ->assertSee('Book an Appointment');
    }

    public function test_registration_user_step_returns_to_the_workflow_entry_for_resolution(): void
    {
        Livewire::test(UserStep::class)
            ->set('email', 'workflow@example.test')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('goToNextStep')
            ->assertRedirect(route('register.start'));
    }

    public function test_registration_demographics_accepts_filled_location_and_phone_fields(): void
    {
        User::factory()->create(['email' => 'workflow@example.test']);

        Livewire::test(DemographicsStep::class)
            ->set('email', 'workflow@example.test')
            ->set('age', '35')
            ->set('location', 'Chicago, IL')
            ->set('phone', '+1 (312) 555-0100')
            ->call('goToNextStep')
            ->assertHasNoErrors()
            ->assertRedirect(route('register.start'));
    }

    public function test_registration_demographics_guard_passes_when_its_namespaced_state_matches_the_user(): void
    {
        $user = User::factory()->create([
            'email' => 'workflow@example.test',
            'age' => 35,
            'location' => 'Chicago, IL',
            'phone' => '+1 (312) 555-0100',
        ]);
        $request = Request::create('/register-test/demographics');
        $request->setUserResolver(fn (): User => $user);

        workflowState('register')
            ->forRequest($request)
            ->set('registration.age', '35')
            ->set('registration.location', 'Chicago, IL')
            ->set('registration.phone', '+1 (312) 555-0100')
            ->set('registration.email', 'workflow@example.test');

        $this->assertTrue(app(DemographicsNotCompletedGuard::class)->passes($request));
    }

    public function test_checkout_completes_after_an_order_is_placed(): void
    {
        $user = User::factory()->create();
        $request = Request::create('/checkout/confirmation');
        $request->setUserResolver(fn (): User => $user);

        workflowState('checkout')
            ->forRequest($request)
            ->set('checkout.cart.cart_items', [[
                'id' => 1,
                'product_name' => 'Workflow Test Product',
                'quantity' => 1,
                'price' => 19.99,
                'subtotal' => 19.99,
            ]])
            ->set('checkout.cart.cart_total', 19.99)
            ->set('checkout.cart.cart_confirmed', true)
            ->set('checkout.shipping.shipping_address', $this->checkoutAddress())
            ->set('checkout.billing.billing_address', $this->checkoutAddress())
            ->set('checkout.payment.selected_payment_method', 'credit_card')
            ->set('checkout.payment.confirmed_payment_method', true);

        Livewire::actingAs($user)
            ->test(CheckoutConfirmationStep::class)
            ->call('placeOrder')
            ->assertHasNoErrors()
            ->assertRedirect(route('checkout.start'));

        $this->actingAs($user)
            ->get(route('checkout.start'))
            ->assertRedirect(route('order.confirmed'));

        $this->assertDatabaseCount('orders', 1);
    }

    private function checkoutAddress(): array
    {
        return [
            'full_name' => 'Workflow Test Buyer',
            'address_line_1' => '1 Test Street',
            'address_line_2' => '',
            'city' => 'Chicago',
            'state' => 'IL',
            'zip_code' => '60601',
            'country' => 'US',
        ];
    }
}
