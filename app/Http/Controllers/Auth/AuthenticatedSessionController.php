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
use App\Models\Plan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Events\VerifyReCaptchaToken;
use Illuminate\Support\Facades\Cookie;

class AuthenticatedSessionController extends Controller
{
    public function __construct(Request $request)
    {
       
    }

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
    public function store(LoginRequest $request)
    {
        


        $user = User::where('email', $request->email)->first();
        if ($user != null) {
            $companyUser = User::where('id', $user->created_by)->first();
        }

        if ($user != null && $user->is_active == 0 && $user->type != 'super admin') {
            return redirect()->back()->with('status', __('Your Account is de-activate,please contact your Administrator.'));
        }

        if ((($user != null && ($user->is_enable_login == 0) && $user->type != 'super admin') || ((isset($companyUser) && $companyUser != null) && $companyUser->is_enable_login == 0))) {
            return redirect()->back()->with('status', __('Your Account is disable,please contact your Administrator.'));
        }

        $request->authenticate();
        $request->session()->regenerate();
        
        \App\Models\Utility::addNewData();

        if (module_is_active('GoogleAuthentication') && isset($user->google2fa_enable) && !empty($user->google2fa_enable)) {
            return redirect()->route('2fa.dashboard');
        }
        elseif (module_is_active('Duo2FA')) {
            return redirect()->route('duo2fa.form');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Clear the language cookie
        Cookie::queue(Cookie::forget('LANGUAGE'));
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showCustomerLoginForm($lang = '')
    {

        return view('auth.customer_login', compact('lang'));
    }
}
