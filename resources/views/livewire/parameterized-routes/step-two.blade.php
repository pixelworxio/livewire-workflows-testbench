<div>
    <h1>Step Two</h1>

    @dump($test, $user)

    <button wire:click="back('parameterized-routes','second-one')">Back</button>
    <button wire:click="goToNextStep">Continue</button>
</div>
