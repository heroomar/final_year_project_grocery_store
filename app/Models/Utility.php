<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Qirolab\Theme\Theme;
use App\Mail\CommonEmailTemplate;
use App\Models\EmailTemplateLang;
use App\Models\WhatsappMessage;
use Twilio\Rest\Client;
use App\Models\{Country, City, Role, Permission, State};
use Workdo\AuctionProduct\app\Models\AuctionProductOrder;
use Workdo\ProductAffiliate\app\Models\AffiliateSetting;
use Workdo\ProductAffiliate\app\Models\AffiliateTransaction;
use Illuminate\Support\Facades\Cache;

class Utility extends Model
{
    use HasFactory;


    
    public static function upload_file($request, $key_name, $name, $path, $custom_validation = [], $image = '')
    {
        // try {
            $store_id = auth()->user()->current_store ?? 1;
           
                $mimes = 'jpg,jpeg,png,giff';
            

                $file = !empty($image) ? $image : $request->$key_name;

                if (count($custom_validation) > 0) {
                    $validation = $custom_validation;
                } else {

                    $validation = [
                        'mimes:' . $mimes,
                        // 'max:' . $max_size,
                    ];
                }

                if (empty($image)) {
                    $validator = \Validator::make($request->all(), [
                        $key_name => $validation
                    ]);
                }


                if (empty($image) && $validator->fails()) {
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {

                    $name = $name;

                    $path = $path . '/';
                    $image = !empty($image) ? $image : $request->file($key_name);
                    
                    
                    \Storage::disk('public')->putFileAs(
                        $path,
                        $image,
                        $name
                    );
                    // dd($path,
                    //     $image,
                    //     $name);
                    // dd(public_path().'/uploads/'.$name);
                    // $image->store(public_path('/uploads/'));
                    $path = $path . $name;
                    

                    $image_url = '';
                    
                    $image_url = url($path);
                    

                    $res = [
                        'flag' => 1,
                        'msg'  => 'success',
                        'url'  => $path,
                        'image_path'  => $path,
                        'full_url'  => $image_url
                    ];
                    // dd($res);
                    return $res;
                }
            
        // } catch (\Exception $e) {
        //     $res = [
        //         'flag' => 0,
        //         'msg' => $e->getMessage(),
        //     ];
        //     return $res;
        // }
    }

    
}

