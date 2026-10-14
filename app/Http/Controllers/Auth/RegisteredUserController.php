<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $minAge = config('calmify.legal.min_age');

        return view('auth.register', compact('minAge'));
    }

    /**
     * Create an anonymous account (username + password only) and sign in.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create($request->safe()->only(['username', 'password']));

        if ($request->boolean('health_data_consent')) {
            $user->grantHealthDataConsent();
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended(route('sos'))->with('status', 'Dein anonymes Konto ist bereit.');
    }
}
