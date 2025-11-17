<div id="stepThreeWrapper">
    <span id="stepThree_{{ now()->timestamp }}">
        This is the step three component - Name: {{ $name ?? 'not set' }}
    </span>

    <div class="mt-5 flex justify-between">
        <button id="step3Back" wire:click="goBack">
            Go Back
        </button>

        <button id="step3Continue" wire:click="goToNextStep" class="ml-auto">
            Continue
        </button>
    </div>

</div>
