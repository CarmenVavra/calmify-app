<?php

namespace App\Http\Controllers;

use App\Services\CrisisDirectory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display preferences (stored on the device) and the anonymous account.
     */
    public function __invoke(Request $request, CrisisDirectory $directory): View
    {
        $user = $request->user();
        $completedExercises = $user?->panicLogs()->count() ?? 0;
        $preferences = config('calmify.preferences');
        $countries = $directory->countries();
        $country = $directory->countryFor($request);
        $countryCookie = config('calmify.country_cookie');

        return view('settings', compact('user', 'completedExercises', 'preferences', 'countries', 'country', 'countryCookie'));
    }
}
