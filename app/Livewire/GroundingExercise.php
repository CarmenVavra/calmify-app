<?php

namespace App\Livewire;

use App\Actions\LogPanicEpisode;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Home screen, 5-4-3-2-1 grounding exercise and completion screen.
 *
 * Counting and the breathing pacer run entirely in Alpine.js (no server
 * round trip per tap). The server is called exactly once, when the
 * exercise has been completed, to write the anonymous panic log.
 */
#[Title('Calmify')]
class GroundingExercise extends Component
{
    /**
     * Logs a completed exercise for signed-in users. Guests stay fully anonymous.
     *
     * Renderless: a re-render would morph the DOM while Alpine shows the
     * completion screen.
     */
    #[Renderless]
    public function complete(mixed $durationMinutes): void
    {
        $validated = Validator::make(
            ['duration_minutes' => $durationMinutes],
            ['duration_minutes' => ['required', 'integer']],
        )->validate();

        $user = Auth::user();

        if ($user === null) {
            return;
        }

        app(LogPanicEpisode::class)->handle($user, (int) $validated['duration_minutes']);
    }

    public function render(): View
    {
        return view('livewire.grounding-exercise');
    }
}
