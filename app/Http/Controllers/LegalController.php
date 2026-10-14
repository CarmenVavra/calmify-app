<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

/**
 * Impressum, privacy policy and "Über Calmify" (medical notice, terms,
 * accessibility). Texts live in the views, the operator's details in
 * config/calmify.php (`legal`).
 */
class LegalController extends Controller
{
    public function imprint(): View
    {
        $legal = config('calmify.legal');

        return view('legal.imprint', compact('legal'));
    }

    public function privacy(): View
    {
        $legal = config('calmify.legal');
        $sessionCookie = config('session.cookie');
        $sessionLifetime = config('session.lifetime');
        $countryCookie = config('calmify.country_cookie');

        return view('legal.privacy', compact('legal', 'sessionCookie', 'sessionLifetime', 'countryCookie'));
    }

    public function about(): View
    {
        $legal = config('calmify.legal');

        return view('legal.about', compact('legal'));
    }
}
