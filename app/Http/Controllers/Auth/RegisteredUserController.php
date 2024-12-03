<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Store;
use App\Models\Plan;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Events\VerifyReCaptchaToken;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;

class RegisteredUserController extends Controller
{
    public function __construct(Request $request)
    {
        
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        
        if(0)
        {
            // try {
            //     config(
            //         [
            //             'mail.driver' => $settings['MAIL_DRIVER'],
            //             'mail.host' => $settings['MAIL_HOST'],
            //             'mail.port' => $settings['MAIL_PORT'],
            //             'mail.encryption' => $settings['MAIL_ENCRYPTION'],
            //             'mail.username' => $settings['MAIL_USERNAME'],
            //             'mail.password' => $settings['MAIL_PASSWORD'],
            //             'mail.from.address' => $settings['MAIL_FROM_ADDRESS'],
            //             'mail.from.name' => $settings['MAIL_FROM_NAME'],
            //         ]
            //     );

            //     $validation = [];

                

            //     $request->validate([
            //         'name' => ['required', 'string', 'max:255'],
            //         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
            //         'store_name' => ['required', 'string', 'max:255'],
            //     ]+$validation);
            //     $superAdmin = Cache::remember('super_admin_details', 3600, function () {
            //         return User::where('type','super admin')->first();
            //     });

            //     $user = User::create([
            //         'name' => $request->name,
            //         'email' => $request->email,
            //         'profile_image' => 'uploads/profile/avatar.png',
            //         'type' => 'admin',
            //         //'email_verified_at' => date('Y-m-d H:i:s'),
            //         'password' => Hash::make($request->password),
            //         'mobile' => '',
            //         'default_language' => $superAdmin->default_language ?? 'en',
            //         'created_by' => 1,
            //         'is_active' => 1,
            //         'theme_id' => 'grocery',
            //     ]);

            //     $slug = User::slugs($request->store_name);

            //     $store = Store::create([
            //             'name' => $request->store_name,
            //             'email' => $request->email,
            //             'theme_id' => $user->theme_id,
            //             'slug' => $slug,
            //             'created_by' => $user->id,
            //             'default_language' => $superAdmin->default_language ?? 'en'
            //         ]);

            //     $user->current_store = $store->id;
            //     $user->save();
            //     event(new Registered($user));
            //     Auth::login($user);
            //     $role_r = Role::where('name', 'admin')->first();
            //     $user->addRole($role_r);
            //     if($user->type == 'admin')
            //     {
            //         $plan = Cache::remember('plan_details_'.$user->id, 3600, function () use ($user) {
            //             return Plan::find($user->plan_id);
            //         });
            //         if($plan)
            //         {
            //             if($plan->duration != 'Unlimited')
            //             {
            //                 $datetime1 = new \DateTime($user->plan_expire_date);
            //                 $datetime2 = new \DateTime(date('Y-m-d'));
            //                 $interval = $datetime2->diff($datetime1);
            //                 $days     = $interval->format('%r%a');
            //                 if($days <= 0)
            //                 {
            //                     $user->assignPlan(1);

            //                     return redirect()->intended(RouteServiceProvider::HOME)->with('error', __('Your Plan is expired.'));
            //                 }
            //             }

            //             if($user->trial_expire_date != null)
            //             {
            //                 if(\Auth::user()->trial_expire_date < date('Y-m-d'))
            //                 {
            //                     $user->assignPlan(1);

            //                     return redirect()->intended(RouteServiceProvider::HOME)->with('error', __('Your Trial plan Expired.'));
            //                 }
            //             }
            //         } elseif (empty($plan) && isset($planId)) {
            //             $user->assignPlan(1);
            //             if (isset($planId) && $planId == 1) {
            //                 return redirect()->intended(RouteServiceProvider::HOME);
            //             } else {
            //                 return redirect()->route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($planId));
            //             }
            //         }
            //     }

            // } catch (\Exception $e) {
            //     $user->delete();

            //     return redirect('/register')->with('status', __('Email SMTP settings does not configure so please contact to your site admin.'));
            // }
            return redirect()->route('verify-email');
        } else {
            $validation = [];
            
            

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                // 'store_name' => ['required', 'string', 'max:255'],
            ]);
            // $superAdmin = Cache::remember('super_admin_details', 3600, function () {
            //     return User::where('type','super admin')->first();
            // });

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'profile_image' => 'uploads/profile/avatar.png',
                
               // 'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make($request->password),
                'mobile' => '',
                // 'plan_id' => 1,
                'default_language' => $superAdmin->default_language ?? 'en',
                'created_by' => 1,
                'is_active' => 1,
                'theme_id' => 'grocery',
            ]);

        

            $user->save();
            Auth::login($user);
            
                    

            return redirect(RouteServiceProvider::HOME);
        }
    }

    public function verify_email()
    {
        return view('auth.verify-email');
    }
}
