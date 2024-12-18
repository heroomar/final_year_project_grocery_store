<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Setting;
use App\Models\Theme;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use \WhichBrowser\Parser;
use App\Mail\TestMail;
use App\Models\Customer;
use App\Models\PixelFields;
use Illuminate\Support\Facades\Cookie;
use App\Models\{Webhook, WhatsappMessage, Plan ,Country,State,City};
use App\Models\Tax;
use App\Models\TaxOption;
use App\Models\EmailTemplate;
use App\Models\ApikeySetiings;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $setting = GetAllSettings();
        return view('setting.index',compact('setting'));
        return view('setting.index');
    }

    

    public function BusinessSettings(Request $request)
    {
        
        if($request->title_text)
        Setting::updateOrCreate([
            'name' => 'title_text',
        ],[
            'value' => $request->title_text
        ]);

        if($request->footer_text)
        Setting::updateOrCreate([
            'name' => 'footer_text',
        ],[
            'value' => $request->footer_text
        ]);

        if($request->footer_text)
        Setting::updateOrCreate([
            'name' => 'footer_text',
        ],[
            'value' => $request->footer_text
        ]);

        if($request->color)
        Setting::updateOrCreate([
            'name' => 'color',
        ],[
            'value' => $request->color
        ]);

        

        $user = auth()->user();
         $theme_id = APP_THEME();
        $dir = 'themes/' . APP_THEME() . '/uploads';
        
        $dir =  Storage::url('uploads/logo');
        if ($request->logo_dark && $request->logo_dark->getClientOriginalExtension() == 'png') {
            
            $defaultName = 'logo-dark.png';
            $fileName = "logo-dark." . $request->logo_dark->getClientOriginalExtension();
            $image_path = 'uploads/logo/logo-dark.png';
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $path = Utility::upload_file($request, 'logo_dark', $fileName, $dir, []);
            
        }

        if ($request->logo_light && $request->logo_light->getClientOriginalExtension() == 'png') {
            
            $defaultName = 'logo-dark.png';
            $fileName = "logo-light." . $request->logo_light->getClientOriginalExtension();
            $image_path = 'uploads/logo/logo-dark.png';
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $path = Utility::upload_file($request, 'logo_light', $fileName, $dir, []);
            
        }

        if ($request->favicon && $request->favicon->getClientOriginalExtension() == 'png') {
            
            $defaultName = 'logo-dark.png';
            $fileName = "favicon." . $request->favicon->getClientOriginalExtension();
            $image_path = 'uploads/logo/logo-dark.png';
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $path = Utility::upload_file($request, 'favicon', $fileName, $dir, []);
            
        }


        
        

        return redirect()->back()->with('success', __('Brand setting successfully updated.'));
    }

    
}
