<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use App\Models\User;
use Hash;

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
        
        $user = User::where('username', $request->username)->first();
        if($user == null){
            return redirect('/login')->with('alert','No account  found.');
        }else{
            if($user->status == 0) {
                return redirect('/login')->with('alert','Your account is archived. Please contact the Principal for more info.');
            }
            $request->authenticate();
    
            $request->session()->regenerate();
    
            // return redirect()->intended(RouteServiceProvider::HOME);
            return redirect('/dashboard');
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

        return redirect('/dashboard');
    }
}
