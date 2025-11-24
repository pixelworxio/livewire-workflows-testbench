<div id="mfaStepWrapper" class="max-w-md mx-auto">
    <div class="px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-2 text-gray-800">Two-Factor Authentication</h2>
        <p class="text-gray-600 mb-6">Enter the 6-digit code to verify your identity.</p>

        @if($showResendMessage)
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                A new code has been sent!
            </div>
        @endif

        <form wire:submit.prevent="verify">
            <!-- MFA Code Field -->
            <div class="mb-6">
                <x-input-label for="mfaCode" value="MFA Code" />
                <x-text-input
                    id="mfaCode"
                    wire:model="mfaCode"
                    type="text"
                    class="mt-1 block w-full text-center text-2xl tracking-widest"
                    maxlength="6"
                    pattern="[0-9]{6}"
                    placeholder="000000"
                    required
                    autofocus
                />
                <x-input-error :messages="$errors->get('mfaCode')" class="mt-2" />
            </div>

            <!-- Demo Code Display -->
            @if($mfaCodeForDemo)
                <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded">
                    <p class="text-sm text-blue-800">
                        <strong>Demo Code:</strong> {{ $mfaCodeForDemo }}
                    </p>
                </div>
            @endif

            <!-- Buttons -->
            <div class="flex flex-col gap-3">
                <x-primary-button type="submit" class="w-full justify-center">
                    Verify Code
                </x-primary-button>

                <button
                    type="button"
                    wire:click="resend"
                    class="text-sm text-indigo-600 hover:text-indigo-800 underline"
                >
                    Resend Code
                </button>
            </div>
        </form>
    </div>
</div>
