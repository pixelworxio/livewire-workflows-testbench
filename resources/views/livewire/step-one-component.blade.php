<div id="stepOneWrapper">
    <div id="stepOne_{{ now()->timestamp }}">
        This is the step one component - Name: {{ $name ?? 'not set' }}
    </div>

    <div class="mt-5 flex justify-between">
        <button id="step1Continue" wire:click="goToNextStep" class="ml-auto">
            Continue
        </button>
    </div>

</div>
