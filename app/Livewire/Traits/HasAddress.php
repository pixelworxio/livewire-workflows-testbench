<?php

namespace App\Livewire\Traits;

trait HasAddress
{
    public function addressIsFilled($address): bool
    {
        $filled = true;

        foreach ($address as $key => $part) {
            if ($key === 'address_line_2') {
                continue; // ignore, this part is nullable
            }

            if (empty($part)) {
                $filled = false;
            }
        }

        return $filled;
    }
}
