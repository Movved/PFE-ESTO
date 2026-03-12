<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Get the authenticated user
        $user = auth()->user();

        // Redirect en se basant sur le role de l'utilisatuer
        switch ($user->role) {
            case 'ADMIN':
                return redirect('/admin/dashboard');
            case 'ENSEIGNANT':
                    $enseignant = \DB::table('ENSEIGNANT')->where('id_user', $user->id_user)->first();
                    if ($enseignant && $enseignant->is_chef) {
                        return redirect()->route('chef.dashboard');
                    }
                    return redirect()->route('enseignant.dashboard');
            case 'ETUDIANT':
                return redirect('/etudiant/dashboard');
            default:
                return redirect('/');
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
