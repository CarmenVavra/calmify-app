<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmergencyContactRequest;
use App\Http\Requests\UpdateEmergencyContactRequest;
use App\Models\EmergencyContact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EmergencyContactController extends Controller
{
    /**
     * Manage the user's trusted people (edit / delete).
     */
    public function index(Request $request): View
    {
        $contacts = $request->user()->emergencyContacts()->oldest('id')->get();

        return view('contacts.index', compact('contacts'));
    }

    public function create(): View
    {
        return view('contacts.create');
    }

    public function store(StoreEmergencyContactRequest $request): RedirectResponse
    {
        $request->user()->emergencyContacts()->create($request->validated());

        return redirect()->route('sos')->with('status', 'Kontakt gespeichert.');
    }

    public function edit(EmergencyContact $contact): View
    {
        Gate::authorize('update', $contact);

        return view('contacts.edit', compact('contact'));
    }

    public function update(UpdateEmergencyContactRequest $request, EmergencyContact $contact): RedirectResponse
    {
        $contact->update($request->validated());

        return redirect()->route('contacts.index')->with('status', 'Kontakt aktualisiert.');
    }

    public function destroy(EmergencyContact $contact): RedirectResponse
    {
        Gate::authorize('delete', $contact);

        $contact->delete();

        return redirect()->route('contacts.index')->with('status', 'Kontakt gelöscht.');
    }
}
