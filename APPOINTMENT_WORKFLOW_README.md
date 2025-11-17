# Appointment Scheduling Workflow

## Overview

This is a complete, production-ready appointment booking workflow for the Livewire Workflows testbench. It demonstrates a real-world multi-step process with parameterized routes, guard-controlled step progression, and database integration.

## Workflow Description

**Name**: `book-appointment`

**Entry Point**: `/book-appointment` (no parameters required on entry)

**Exit Point**: `appointment.confirmed` route

**Purpose**: Allow authenticated users to book appointments by selecting a service, provider, date/time, and confirming their booking.

---

## Workflow Steps

### Step 1: Service Selection
- **Route**: `/book-appointment/select-service`
- **Component**: `App\Livewire\Appointments\ServiceSelection`
- **Guard**: `App\Guards\Appointments\ServiceNotSelectedGuard`
- **Purpose**: Display all available services in a grid layout and allow user to select one
- **Data Collected**: `service_id`

**Features**:
- Displays service name, description, price, and duration
- Visual card-based UI with hover effects
- Click-to-select interaction
- Stores selection in session and workflow state

---

### Step 2: Provider Selection
- **Route**: `/book-appointment/select-provider`
- **Component**: `App\Livewire\Appointments\ProviderSelection`
- **Guard**: `App\Guards\Appointments\ProviderNotSelectedGuard`
- **Purpose**: Display available providers and allow user to select one
- **Data Collected**: `provider_id`

**Features**:
- Displays only available providers (`is_available = true`)
- Shows provider name and specialty
- Avatar placeholder with provider initial
- Back button to return to service selection
- Stores selection in session and workflow state

---

### Step 3: Time Slot Selection
- **Route**: `/book-appointment/select-time`
- **Component**: `App\Livewire\Appointments\TimeSlotSelection`
- **Guard**: `App\Guards\Appointments\TimeSlotNotSelectedGuard`
- **Purpose**: Allow user to select appointment date and time
- **Data Collected**: `scheduled_at` (combined date and time)

**Features**:
- Date input (minimum: today)
- Dynamic time slot generation (9 AM - 5 PM, 30-minute intervals)
- Real-time UI updates when date changes
- Filters out past time slots for today
- Visual selection state for time slots
- Validation for date and time
- Back button to return to provider selection
- Stores selection in session and workflow state

---

### Step 4: Confirmation
- **Route**: `/book-appointment/confirm-appointment`
- **Component**: `App\Livewire\Appointments\ConfirmationStep`
- **Guard**: None (always executed)
- **Purpose**: Display appointment summary and create the appointment in database
- **Action**: Creates `Appointment` record in database

**Features**:
- Comprehensive appointment summary card
- Displays all selected information (service, provider, date/time, pricing)
- Optional notes field for additional information
- Important information callout box
- Back button to return to time selection
- Creates appointment record on confirmation
- Redirects to success page with appointment details

---

## Directory Structure

```
app/
├── Guards/
│   └── Appointments/
│       ├── ServiceNotSelectedGuard.php
│       ├── ProviderNotSelectedGuard.php
│       └── TimeSlotNotSelectedGuard.php
├── Livewire/
│   └── Appointments/
│       ├── ServiceSelection.php
│       ├── ProviderSelection.php
│       ├── TimeSlotSelection.php
│       └── ConfirmationStep.php
└── Models/
    ├── Service.php (existing)
    ├── Provider.php (existing)
    └── Appointment.php (existing)

database/
├── factories/
│   ├── ServiceFactory.php
│   ├── ProviderFactory.php
│   └── AppointmentFactory.php
└── seeders/
    └── AppointmentWorkflowSeeder.php

resources/
└── views/
    ├── appointments/
    │   └── confirmed.blade.php
    └── livewire/
        └── appointments/
            ├── service-selection.blade.php
            ├── provider-selection.blade.php
            ├── time-slot-selection.blade.php
            └── confirmation-step.blade.php

routes/
├── workflows.php (workflow definition added)
└── web.php (confirmation route added)
```

---

## Database Schema

### Services Table
```php
- id (primary key)
- name (string)
- description (text)
- duration_minutes (integer)
- price (decimal)
- created_at
- updated_at
```

### Providers Table
```php
- id (primary key)
- name (string)
- specialty (string)
- is_available (boolean)
- created_at
- updated_at
```

### Appointments Table
```php
- id (primary key)
- user_id (foreign key -> users)
- service_id (foreign key -> services)
- provider_id (foreign key -> providers)
- scheduled_at (datetime)
- status (string: scheduled, confirmed, completed, cancelled)
- notes (text, nullable)
- created_at
- updated_at
```

---

## Workflow State Management

The workflow uses the `#[WorkflowState]` attribute to persist data across steps:

```php
#[WorkflowState]
public ?int $serviceId = null;

#[WorkflowState]
public ?int $providerId = null;

#[WorkflowState]
public ?string $scheduledAt = null;
```

Additionally, session storage is used for guard checks:
- `appointment_service_id` - Set when service is selected
- `appointment_provider_id` - Set when provider is selected
- `appointment_scheduled_at` - Set when time slot is selected

---

## Guards Explained

### ServiceNotSelectedGuard

**Logic**: Returns `true` if `appointment_service_id` exists in session (step will be SKIPPED)

**Purpose**: Skip service selection if user has already selected a service

**Use Case**: Allows users to navigate back and forth without losing progress

---

### ProviderNotSelectedGuard

**Logic**: Returns `true` if `appointment_provider_id` exists in session (step will be SKIPPED)

**Purpose**: Skip provider selection if user has already selected a provider

**Use Case**: Allows users to navigate back and forth without losing progress

---

### TimeSlotNotSelectedGuard

**Logic**: Returns `true` if `appointment_scheduled_at` exists in session (step will be SKIPPED)

**Purpose**: Skip time slot selection if user has already selected a time

**Use Case**: Allows users to navigate back and forth without losing progress

---

## Installation & Setup

### 1. Ensure Database is Migrated

All necessary migrations already exist in the repository. Run:

```bash
php artisan migrate
```

### 2. Seed Sample Data

Seed the database with sample services and providers:

```bash
php artisan db:seed --class=AppointmentWorkflowSeeder
```

This creates:
- 6 services (various types with different durations and prices)
- 6 providers (5 available, 1 unavailable for testing)

### 3. Create a Test User

If you don't have a user account, create one:

```bash
php artisan tinker
>>> User::factory()->create(['email' => 'test@example.com', 'password' => bcrypt('password')]);
```

### 4. Start the Development Server

```bash
php artisan serve
```

### 5. Access the Workflow

1. Navigate to `http://localhost:8000`
2. Login with your credentials
3. Visit `http://localhost:8000/book-appointment`
4. Complete the booking process

---

## Testing the Workflow

### Manual Testing Checklist

- [ ] **Step 1: Service Selection**
  - [ ] All 6 services are displayed
  - [ ] Service cards show name, description, price, and duration
  - [ ] Clicking a service stores the selection and advances to next step

- [ ] **Step 2: Provider Selection**
  - [ ] Only 5 available providers are shown (unavailable provider is hidden)
  - [ ] Provider cards show name and specialty
  - [ ] Clicking a provider stores the selection and advances to next step
  - [ ] "Back" button returns to service selection

- [ ] **Step 3: Time Slot Selection**
  - [ ] Date input defaults to tomorrow
  - [ ] Changing date updates available time slots
  - [ ] Time slots are shown from 9 AM to 5 PM (30-minute intervals)
  - [ ] Past time slots are hidden if today is selected
  - [ ] Selected time slot is visually highlighted
  - [ ] Validation errors appear for missing date/time
  - [ ] "Back" button returns to provider selection
  - [ ] "Continue" button advances to confirmation

- [ ] **Step 4: Confirmation**
  - [ ] All appointment details are displayed correctly
  - [ ] Service, provider, date/time, price are accurate
  - [ ] Optional notes field is present
  - [ ] "Back" button returns to time selection
  - [ ] "Confirm Appointment" button creates the appointment

- [ ] **Confirmation Page**
  - [ ] Success message is displayed
  - [ ] Appointment details are shown
  - [ ] Appointment record exists in database
  - [ ] Session workflow data is cleared
  - [ ] "Go to Dashboard" and "Book Another Appointment" buttons work

### Back Navigation Testing

- [ ] From Step 2, clicking "Back" returns to Step 1
- [ ] From Step 3, clicking "Back" returns to Step 2
- [ ] From Step 4, clicking "Back" returns to Step 3
- [ ] Previously selected data is retained when going back
- [ ] Forward progression after going back skips completed steps

### Guard Testing

Test that guards properly skip steps when data exists:

1. **Service Guard Test**:
   ```php
   // In browser console or controller
   session()->put('appointment_service_id', 1);
   // Visit /book-appointment - should skip to provider selection
   ```

2. **Provider Guard Test**:
   ```php
   session()->put('appointment_service_id', 1);
   session()->put('appointment_provider_id', 1);
   // Visit /book-appointment - should skip to time selection
   ```

3. **Time Slot Guard Test**:
   ```php
   session()->put('appointment_service_id', 1);
   session()->put('appointment_provider_id', 1);
   session()->put('appointment_scheduled_at', now()->addDay()->toDateTimeString());
   // Visit /book-appointment - should go to confirmation
   ```

---

## Design Patterns Used

### 1. SOLID Principles

**Single Responsibility**:
- Each guard checks ONE condition (service selected, provider selected, time selected)
- Each component handles ONE step (service selection, provider selection, etc.)
- Each view displays ONE step's UI

**Open/Closed**:
- New steps can be added without modifying existing components
- Guards can be reused in other workflows

**Liskov Substitution**:
- All guards implement `GuardContract`
- Any guard can be swapped for another

**Interface Segregation**:
- `GuardContract` defines minimal required methods
- Components use `InteractsWithWorkflows` trait for opt-in functionality

**Dependency Inversion**:
- Components depend on `GuardContract` abstraction
- No direct coupling to concrete guard implementations

### 2. DRY (Don't Repeat Yourself)

- Blade components (`x-primary-button`, `x-secondary-button`, `x-text-input`) are reused
- Guard structure is consistent across all guards
- Session key naming follows a pattern (`appointment_*`)

### 3. KISS (Keep It Simple, Stupid)

- Clear, descriptive component and guard names
- Straightforward workflow progression
- Minimal abstractions
- Self-documenting code

---

## Key Features Demonstrated

### Workflow State Persistence
```php
#[WorkflowState]
public ?int $serviceId = null;
```

Properties marked with `#[WorkflowState]` are automatically persisted across steps.

### Guard-Based Step Control
```php
public function passes(Request $request): bool
{
    return $request->session()->has('appointment_service_id');
}
```

Guards determine whether steps should be executed or skipped.

### Back Navigation
```php
public function goBack(): void
{
    session()->forget('appointment_provider_id');
    $this->providerId = null;
    $this->back('book-appointment');
}
```

Clear session data when navigating backwards to allow re-selection.

### Form Validation
```php
protected function rules(): array
{
    return [
        'selectedDate' => 'required|date|after_or_equal:today',
        'selectedTime' => 'required',
    ];
}
```

Livewire validation ensures data integrity before progression.

### Database Integration
```php
$appointment = Appointment::create([
    'user_id' => auth()->id(),
    'service_id' => $this->serviceId,
    'provider_id' => $this->providerId,
    'scheduled_at' => $this->scheduledAt,
    'status' => 'scheduled',
    'notes' => $this->notes,
]);
```

Final step creates actual database records.

---

## Extending the Workflow

### Add Email Notifications

In `ConfirmationStep::confirmAppointment()`:

```php
// Send confirmation email
Mail::to(auth()->user())->send(new AppointmentConfirmed($appointment));
```

### Add Calendar Integration

```php
// Generate calendar invite
$calendar = new Calendar($appointment);
return response()->download($calendar->generate());
```

### Add SMS Reminders

```php
// Schedule reminder notification
$appointment->user->notify(
    (new AppointmentReminder($appointment))->delay($appointment->scheduled_at->subDay())
);
```

### Add Payment Processing

Create a new step between time selection and confirmation:

```php
->step('payment')
    ->goTo(PaymentStep::class)
    ->unlessPasses(PaymentCompletedGuard::class)
    ->order(35)
```

---

## Troubleshooting

### Issue: Services not displaying

**Solution**: Run the seeder:
```bash
php artisan db:seed --class=AppointmentWorkflowSeeder
```

### Issue: No providers showing

**Check**: Ensure providers have `is_available = true` in database

### Issue: Workflow loops back to first step

**Cause**: Guards returning incorrect boolean values

**Solution**: Guards should return `true` to SKIP, `false` to EXECUTE

### Issue: Appointment not created

**Check**:
1. User is authenticated
2. All required data is in session
3. Database migrations are run

---

## File Summary

### Created Files

**Guards (3 files)**:
- `/app/Guards/Appointments/ServiceNotSelectedGuard.php`
- `/app/Guards/Appointments/ProviderNotSelectedGuard.php`
- `/app/Guards/Appointments/TimeSlotNotSelectedGuard.php`

**Components (4 files)**:
- `/app/Livewire/Appointments/ServiceSelection.php`
- `/app/Livewire/Appointments/ProviderSelection.php`
- `/app/Livewire/Appointments/TimeSlotSelection.php`
- `/app/Livewire/Appointments/ConfirmationStep.php`

**Views (5 files)**:
- `/resources/views/livewire/appointments/service-selection.blade.php`
- `/resources/views/livewire/appointments/provider-selection.blade.php`
- `/resources/views/livewire/appointments/time-slot-selection.blade.php`
- `/resources/views/livewire/appointments/confirmation-step.blade.php`
- `/resources/views/appointments/confirmed.blade.php`

**Factories (3 files)**:
- `/database/factories/ServiceFactory.php`
- `/database/factories/ProviderFactory.php`
- `/database/factories/AppointmentFactory.php`

**Seeders (1 file)**:
- `/database/seeders/AppointmentWorkflowSeeder.php`

**Modified Files**:
- `/routes/workflows.php` - Added workflow definition
- `/routes/web.php` - Added confirmation route
- `/database/seeders/DatabaseSeeder.php` - Added seeder call

### Existing Files Used

**Models** (already existed):
- `/app/Models/Service.php`
- `/app/Models/Provider.php`
- `/app/Models/Appointment.php`
- `/app/Models/User.php`

**Migrations** (already existed):
- Services table migration
- Providers table migration
- Appointments table migration

---

## Testing Commands

```bash
# Run migrations
php artisan migrate

# Seed appointment workflow data
php artisan db:seed --class=AppointmentWorkflowSeeder

# View all workflow routes
php artisan route:list --path=book-appointment

# Clear workflow session data
php artisan tinker
>>> session()->forget(['appointment_service_id', 'appointment_provider_id', 'appointment_scheduled_at']);

# Create test appointment
php artisan tinker
>>> App\Models\Appointment::factory()->create();
```

---

## Workflow Diagram

```
Entry: /book-appointment
│
├─> Step 1: Service Selection
│   ├─ Guard: ServiceNotSelectedGuard
│   ├─ View: Select from 6 services
│   └─ Data: service_id → session
│
├─> Step 2: Provider Selection
│   ├─ Guard: ProviderNotSelectedGuard
│   ├─ View: Select from available providers
│   ├─ Action: Back to Step 1
│   └─ Data: provider_id → session
│
├─> Step 3: Time Slot Selection
│   ├─ Guard: TimeSlotNotSelectedGuard
│   ├─ View: Select date and time
│   ├─ Action: Back to Step 2
│   └─ Data: scheduled_at → session
│
├─> Step 4: Confirmation
│   ├─ Guard: None (always executed)
│   ├─ View: Review and confirm
│   ├─ Action: Create appointment in database
│   └─ Data: Create Appointment record
│
└─> Exit: /appointment-confirmed
    └─ Success page with appointment details
```

---

## Conclusion

This appointment booking workflow demonstrates a complete, production-ready implementation of the Livewire Workflows package. It showcases:

- Multi-step process with guard-controlled progression
- Session-based state persistence
- Database integration
- Form validation
- Back navigation
- Visual UI with Tailwind CSS
- SOLID, DRY, and KISS principles
- Real-world use case

The workflow is fully functional and can be used as a reference for building similar multi-step processes in Laravel applications.

---

**Last Updated**: 2025-11-17
**Laravel Version**: 12.x
**Livewire Version**: 3.6.4
**Package**: pixelworxio/livewire-workflows@dev
