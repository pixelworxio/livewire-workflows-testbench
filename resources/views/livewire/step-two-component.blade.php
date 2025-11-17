<div id="stepTwoWrapper">
    <span id="stepTwo_{{ now()->timestamp }}">
        This is the step two component - Name: {{ $name ?? 'not set' }}
    </span>

    <div class="mt-5 flex justify-between">
        <button id="step2Back" wire:click="goBack">
            Go Back
        </button>

        <button id="step2Continue" wire:click="goToNextStep" class="ml-auto">
            Continue
        </button>
    </div>

</div>
