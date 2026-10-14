<?php

namespace App\Http\Controllers;

use App\Services\CrisisDirectory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SosController extends Controller
{
    /**
     * One-tap calls to trusted people and 24/7 crisis services.
     */
    public function __invoke(Request $request, CrisisDirectory $directory): View
    {
        $contacts = $request->user()?->emergencyContacts()->oldest('id')->get() ?? collect();
        $country = $directory->countryFor($request);
        $services = $directory->servicesFor($country);
        $emergencyNumber = $directory->emergencyNumberFor($country);

        return view('sos', compact('contacts', 'services', 'emergencyNumber'));
    }
}
