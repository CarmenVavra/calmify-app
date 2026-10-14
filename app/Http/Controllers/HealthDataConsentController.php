<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHealthDataConsentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HealthDataConsentController extends Controller
{
    /**
     * Start storing completed exercises (explicit consent, Art. 9 GDPR).
     */
    public function store(StoreHealthDataConsentRequest $request): RedirectResponse
    {
        $request->user()->grantHealthDataConsent();

        return redirect()->route('settings')->with('status', 'Deine Übungen werden ab jetzt in deinem Konto gespeichert.');
    }

    /**
     * Withdraw consent and delete all exercise logs.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->user()->revokeHealthDataConsent();

        return redirect()->route('settings')->with('status', 'Einwilligung widerrufen. Alle Übungsprotokolle wurden gelöscht.');
    }
}
