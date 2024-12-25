<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\OrderCouponDetail;
use Illuminate\Http\Request;
use App\Models\Utility;
use App\Models\{Customer, Country, Order, PlanOrder, Plan, PlanCoupon, PlanRequest, Store, Setting, User,OrderBillingDetail , PixelFields, Page,Cart};
use App\Models\Faq;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\BlogCategory;
use App\Models\Blog;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\{FlashSale, ProductQuestion, Testimonial, Wishlist,TaxOption};
use Qirolab\Theme\Theme;
use App\Http\Controllers\Api\ApiController;
use Shetabit\Visitor\VisitorFacade as Visitor;
use App\Facades\ModuleFacade as Module;
use App\Models\AddOnManager;
use App\Models\ProductBrand;
use App\Http\Controllers\OfertemagController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
   

    /**
     * Display a listing of the resource.
     */
    public function success(){
      return view("front.success");
    }
     public function Landing()
    {
        // if (auth()->user()) {
        //     return redirect('dashboard');
        // }
        $products = Product::orderBy('id','desc')->get();
        // $products = $products->paginate(20);
        $cart  = session()->get('cart');
        if(!is_array($cart)){
          $cart=[];
          session()->put('cart' , $cart);
        }
        return view('front.index',compact('products'));
        
    }

    
    public function categories(Request $request){
      
      $categories = SubCategory::get();
      return view('front.categories',compact('categories'));
  }

    public function products(Request $request){
        $products = Product::orderBy('id','desc');

        if ($request->category != ''){
            $SubCats = \App\Models\SubCategory::where('maincategory_id', ($_GET['category'] ?? 0))->get()->pluck('id')->toArray();
            $products = Product::whereIn('subcategory_id',$SubCats);
        }

        if ($request->subcategory != ''){
          $products = Product::where('subcategory_id',$request->subcategory);
        }

        if ($request->search != ''){
            $products = Product::whereRaw('name LIKE "%'.$request->search.'%" ');
        }
        // dd($products->toSql());
        $products = $products->paginate(15);
        $categories = MainCategory::get();
        return view('front.products',compact('products','categories'));
    }

    public function index()
    {
        $user = auth()->user();
        
          $data = $this->handleSuperAdmin($user);

            return view('superadmin.dashboard', $data);
       
    }

    public function about(){
      return view('front.about');
    }
    
    public function contact(){
      return view('front.contact');
    }

    private function handleSuperAdmin($user)
    {
        $user['total_user'] = User::where('role','!=', 1 )->count();
        $user['total_orders'] = Order::count();
        $user['total_plan'] = Customer::count();
        $user['sales'] = Order::sum('product_price');
        $chartData = [
        rand(11,99),
        rand(11,99),
        rand(11,99),
        rand(11,99),
        rand(11,99),
        rand(11,99),
        rand(11,99)
      ];
        $topAdmins = Customer::get();

        
        $visitors = [0,0,0,0,0];

        $plan_order = [];
        $coupons = [];
        $maxValue = 0;
        $couponName = '';
        

        $allStores = [];
        $plan_requests = 0;

        $data =  compact('user', 'chartData', 'couponName', 'plan_order', 'plan_requests', 'allStores', 'topAdmins', 'visitors');
        return $data;
    }

    public function addcart(Request $request,$id){
      $cart  = session()->get('cart');
      if(!is_array($cart)){
        $cart=[];
        session()->put('cart' , $cart);
      }
      $product = Product::find($id)->toArray();
      if ($product){
        $product['qty'] = 1;
        if (isset($cart[$product['id']])){
          $cart[$product['id']]['qty']++;
        } else {
          $cart[$product['id']] = $product;
        }
      }
      
      session()->put('cart' , $cart);
      return redirect(url('cart'));
    }

    public function cart(Request $request){
      
      $cart  = session()->get('cart');
      $cart_extra  = session()->get('cart_extra');
      if(!is_array($cart)){
        $cart=[];
        session()->put('cart' , $cart);
      }

      
      if (!$cart_extra){
        $cart_extra = ['discount'=>0 ,'coupon' => null];
        $cart_extra  = session()->put('cart_extra',$cart_extra);
      }


      $total = 0;
      $_total = 0;
      
      foreach ($cart as $product){
      
        if ($product['sale_price'] > 0 && $product['price'] > $product['sale_price']){
          $total +=  $product['qty'] * $product['sale_price'];
        } else {
          $total +=  $product['qty'] * $product['price'];
          
        }
        $_total +=  $product['qty'] * $product['price'];
      }

      if ($request->coupon){
        $coupon =  Coupon::where(['coupon_code'=>$request->coupon,'status'=>1])->where('coupon_expiry_date' ,'>', now())->first();
        
        $discount = 0;
        if ($coupon){
          if ($coupon->coupon_type == 'percentage'){
              $discount = $total * ($coupon->discount_amount/100);
          } else {
              $discount = $coupon->discount_amount;
          }
        }
        $cart_extra = ['discount'=> $discount ,'coupon' => $coupon];
        session()->put('cart_extra',$cart_extra);
      }
      
      return view('front.cart',compact('cart','cart_extra'));
    }

    public function deletecart(Request $request){
      $cart  = session()->get('cart');
      if(!is_array($cart)){
        $cart=[];
        session()->put('cart' , $cart);
      }
      $_cart=[];

      if (!$request->id){
        session()->put('cart' , []);
      } else {
        foreach ($cart as $product) {
          if ($product['id'] != $request->id){
            $_cart[] = $product;
          }
        }
        session()->put('cart' , $_cart);
      }
      
      return redirect(url('cart'));
    }

    public function checkout(Request $request){
      $cart  = session()->get('cart');
      $cart_extra  = session()->get('cart_extra');
      if (!$cart_extra){
              $cart_extra = ['discount'=>0 ,'coupon' => null];
              $cart_extra  = session()->put('cart_extra',$cart_extra);
      }
      return view('front.checkout',compact('cart','cart_extra'));
    }

    public function storecheckout(Request $request){
      $cart  = session()->get('cart');
      $cart_extra  = session()->get('cart_extra');
      if (!$cart_extra){
              $cart_extra = ['discount'=>0 ,'coupon' => null];
              $cart_extra  = session()->put('cart_extra',$cart_extra);
      }
      if(!is_array($cart)){
        $cart=[];
        session()->put('cart' , $cart);
      }

      if (count($cart) > 0){

        $total = 0;
        $_total = 0;
        
        foreach ($cart as $product){
        
          if ($product['sale_price'] > 0 && $product['price'] > $product['sale_price']){
            $total +=  $product['qty'] * $product['sale_price'];
          } else {
            $total +=  $product['qty'] * $product['price'];
            
          }
          $_total +=  $product['qty'] * $product['price'];
        }


          $discount=$cart_extra['discount'];
          $theme_id = APP_THEME();

          
          $currency_symbol = 'Rs';
          $price = $total - ($discount);
          $customer = Customer::updateOrCreate([
            'first_name' => $request->fullName,
            'last_name' => $request->fullName,
            'email' => $request->email,
            'type' => 'cutsomer',
            'mobile' => $request->phone,
            'address' => $request->address,
            'city_name' => $request->city_name,
            'country_name' => $request->country_name,
            'postcode' => $request->postcode,
            'status' => 0
          ]);

          $user =  User::updateOrCreate([
            'name' => $request->fullName,
            'email' => $request->email,
            'role' => 3,
            'password' => Hash::make($request->email),
            'email_verified_at' => date("Y-m-d H:i:s"),
          ]);
          

          if ($user){
            auth()->login($user);
          }

          
          $loopPrice = 0;
          $loopQty = 0;

            foreach ($cart as $key => $value) {

              $cart[$key]['cover_image_path'] = '';
              $cart[$key]['cover_image_url'] = '';
              $cart[$key]['stock_status'] = '';
              $cart[$key]['description'] = '';
              $cart[$key]['detail'] = '';
              $cart[$key]['specification'] = '';
              $cart[$key]['product_data']='';
              $cart[$key]['sub_categoryct_data']='';

              $cart[$key]['quantity']=$value['qty'];
              $cart[$key]['orignal_price']=$value['price'];
              

              $product_id = $value['id'];
              $value['quantity'] = $value['qty'];
              $value['orignal_price'] = $value['price'];
              $original_quantity = ($value == null) ? 0 : (int)$value['product_stock'];

              $product_quantity = $original_quantity - $value['quantity'];
              
              Product::where('id', $product_id)->update(['product_stock' => $product_quantity]);
              
              $loopPrice += $value['orignal_price'];
              $loopQty += $value['quantity'];
              $tax_amount = 0;
              // $price += $value['total_orignal_price'];
              
            }

            $pos   = new Order();
            $pos->delivered_status = 4;
            $pos->product_order_id = time()+rand(1111,9999);
            $pos->order_date = date('Y-m-d H:i:s');
            $pos->customer_id            = $customer->id;
            $pos->is_guest = 1;
            $pos->product_id = $product_id;
            $pos->product_json = json_encode($cart);
            $pos->final_price = ($price-$discount);
            
            
            $pos->product_price = $price;
            
            $pos->coupon_price = (float)$discount;
            $pos->delivery_price = 0;
            $pos->tax_price = $tax_amount;
            $pos->payment_type = __('cod');
            $pos->payment_status = 'Paid';
            $pos->theme_id = $theme_id;
            $pos->store_id = getCurrentStore();
            $pos->user_id = auth()->id();
            $pos->save();


            if ($cart_extra['coupon']){
            
              $OrderCouponDetail = new OrderCouponDetail();
              $OrderCouponDetail->order_id = $pos->id;
              
              $OrderCouponDetail->coupon_id = $cart_extra['coupon']->id; 
              $OrderCouponDetail->coupon_name = $cart_extra['coupon']->coupon_name; 
              $OrderCouponDetail->coupon_code = $cart_extra['coupon']->coupon_code; 
              $OrderCouponDetail->coupon_discount_type = $cart_extra['coupon']->coupon_type; 
              $OrderCouponDetail->coupon_discount_amount = $cart_extra['coupon']->discount_amount; 
              $OrderCouponDetail->coupon_final_amount = $discount; 
              $OrderCouponDetail->theme_id = $cart_extra['coupon']->theme_id;             
              $OrderCouponDetail->save();
  
              
            }

          
            
      }
      session()->put('cart' , []);
      session()->forget('cart_extra');
      
      return redirect(url('success'));
    }

    // private function handleRegularUser($user)
    // {
    //     $todayStart = Carbon::today();
    //     $todayEnd = Carbon::now();
    //     $yesterdayStart = Carbon::yesterday();
    //     $yesterdayEnd = Carbon::yesterday()->endOfDay();
    //     $productQuery = Product::where('theme_id', APP_THEME())->where('product_type', null)->where('store_id', getCurrentStore());
    //     $orderQuery = Order::where('theme_id', APP_THEME())->where('store_id', getCurrentStore());

    //     $totalproduct = (clone $productQuery)->count();
    //     $today_product = (clone $productQuery)->whereBetween('created_at', [$todayStart, $todayEnd])->count();
    //     $productPer = $this->calculatePercentageToday($today_product, $totalproduct);

    //     $totle_order = (clone $orderQuery)->count();
    //     $customerQuery = Customer::where('theme_id', APP_THEME())->where('store_id', getCurrentStore());
    //     $totle_customers = (clone $customerQuery)->where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->count();
    //     $today_customers = (clone $customerQuery)->whereBetween('created_at', [$todayStart, $todayEnd])->count();
    //     $customerPer = $this->calculatePercentageToday($today_customers, $totle_customers);

    //     $totle_cancel_order = (clone $orderQuery)->where('delivered_status', 2)->count();

    //     $total_revenues = (clone $orderQuery)->where(function ($query) {
    //         $query->where(function ($subquery) {
    //             $subquery->where('delivered_status', '!=', 2)
    //                 ->where('delivered_status', '!=', 3);
    //         })->orWhere('return_status', '!=', 2);
    //     })->sum('final_price');

    //     $topSellingProductIds = (clone $orderQuery)->pluck('product_id')
    //         ->flatMap(function ($productIds) {
    //             return explode(',', $productIds);
    //         })
    //         ->map(function ($productId) {
    //             return (int)$productId;
    //         })
    //         ->groupBy(function ($productId) {
    //             return $productId;
    //         })
    //         ->map(function ($group) {
    //             return $group->count();
    //         })
    //         ->sortDesc()
    //         ->take(5)
    //         ->keys();

    //     $topSellingProducts = (clone $productQuery)->whereIn('id', $topSellingProductIds)->get();
    //     $theme_name = APP_THEME() ? APP_THEME() : env('DATA_INSERT_APP_THEME');
    //     $out_of_stock_threshold = Utility::GetValueByName('out_of_stock_threshold', $theme_name, getCurrentStore());
    //     $latests = (clone $productQuery)->orderBy('created_at', 'Desc')->limit(5)->get();

    //     $orderCountsToday = $this->getOrderCounts($orderQuery, $todayStart, $todayEnd);
    //     $orderCounts = $this->getOrderCounts($orderQuery);
    //     //$orderCountsYesterday = $this->getOrderCounts($orderQuery, $yesterdayStart, $yesterdayEnd);

    //     $totalOrderPer = $this->calculatePercentageToday($orderCountsToday['total'], $orderCounts['total']);
    //     $pendingOrderPer = $this->calculatePercentageToday($orderCountsToday['pending'], $orderCounts['pending']);
    //     $completeOrderPer = $this->calculatePercentageToday($orderCountsToday['complete'], $orderCounts['complete']);
    //     $deliveredOrderPer = $this->calculatePercentageToday($orderCountsToday['delivered'], $orderCounts['delivered']);
    //     $cancelOrderPer = $this->calculatePercentageToday($orderCountsToday['cancel'], $orderCounts['cancel']);
    //     $returnOrderPer = $this->calculatePercentageToday($orderCountsToday['return'], $orderCounts['return']);
    //     $shippedOrderPer = $this->calculatePercentageToday($orderCountsToday['shipped'], $orderCounts['shipped']);

    //     $pending_order = $orderCounts['pending'];
    //     $delivered_order = $orderCounts['delivered'];
    //     $cancel_order = $orderCounts['cancel'];
    //     $return_order = $orderCounts['return'];
    //     $confirmed_order = $orderCounts['complete'];
    //     $shipped_order = $orderCounts['shipped'];
    //     $new_orders = $orderQuery->orderBy('id', 'DESC')->limit(5)->get();
    //     $chartData = $this->getOrderChart(['duration' => 'week']);

    //     $store = Cache::remember('store_' . getCurrentStore(), 3600, function () {
    //         return Store::where('id', getCurrentStore())->first();
    //     });
    //     $slug = $store->slug;
    //     $storage_limit = 0;
    //     $users = User::find($user->id);
    //     $plan = null;
    //     if ($users) {
    //         $plan = Plan::find($users->plan_id);
    //         if ($plan && $plan->storage_limit > 0) {
    //             $storage_limit = ($user->storage_limit / $plan->storage_limit) * 100;
    //         }
    //     }


    //     $theme_url = $this->getThemeUrl($store);

    //     $data = compact(
    //         'totalproduct', 'totle_order', 'totle_customers', 'latests', 'new_orders', 'chartData',
    //         'theme_url', 'store', 'storage_limit', 'users', 'plan', 'topSellingProducts', 'total_revenues',
    //         'totle_cancel_order', 'out_of_stock_threshold', 'theme_name', 'pending_order',
    //         'delivered_order', 'cancel_order', 'return_order', 'confirmed_order','totalOrderPer','pendingOrderPer','completeOrderPer','deliveredOrderPer','cancelOrderPer','returnOrderPer', 'customerPer','productPer','shippedOrderPer','shipped_order'
    //     );
    //     return $data;
    // }

    // private function getOrderCounts($orderQuery, $start=null, $end=null)
    // {
    //     if (!empty($start) && !empty($end)) {
    //         return [
    //             'total' => (clone $orderQuery)->whereBetween('created_at', [$start, $end])->count(),
    //             'pending' => (clone $orderQuery)->where('delivered_status', 0)->whereBetween('created_at', [$start, $end])->count(),
    //             'delivered' => (clone $orderQuery)->where('delivered_status', 1)->whereBetween('created_at', [$start, $end])->count(),
    //             'complete' => (clone $orderQuery)->where('delivered_status', 4)->whereBetween('created_at', [$start, $end])->count(),
    //             'cancel' => (clone $orderQuery)->where('delivered_status', 2)->whereBetween('created_at', [$start, $end])->count(),
    //             'return' => (clone $orderQuery)->where('delivered_status', 3)->whereBetween('created_at', [$start, $end])->count(),
    //             'shipped' => (clone $orderQuery)->where('delivered_status', 5)->whereBetween('created_at', [$start, $end])->count(),
    //         ];
    //     } else {
    //         return [
    //             'total' => (clone $orderQuery)->count(),
    //             'pending' => (clone $orderQuery)->where('delivered_status', 0)->count(),
    //             'delivered' => (clone $orderQuery)->where('delivered_status', 1)->count(),
    //             'complete' => (clone $orderQuery)->where('delivered_status', 4)->count(),
    //             'cancel' => (clone $orderQuery)->where('delivered_status', 2)->count(),
    //             'return' => (clone $orderQuery)->where('delivered_status', 3)->count(),
    //             'shipped' => (clone $orderQuery)->where('delivered_status', 5)->count(),
    //         ];
    //     }
    // }

    // private function calculatePercentageToday($todayCount, $allCount)
    // {
    //     if ($allCount == 0) {
    //         return $todayCount > 0 ? 100 : 0;
    //     }
    //     $percentage = (($todayCount - $allCount) / $allCount) * 100;
    //     if ($percentage > 0) {
    //         return '+ '.number_format( $percentage, 2);
    //     } else {
    //         return number_format( $percentage, 2);
    //     }

    // }

    // private function getThemeUrl($store)
    // {
    //     $enable_storelink = Utility::GetValueByName('enable_storelink', $store->theme_id, $store->id);
    //     $enable_domain = Utility::GetValueByName('enable_domain', $store->theme_id, $store->id);
    //     $enable_subdomain = Utility::GetValueByName('enable_subdomain', $store->theme_id, $store->id);
    //     $domains = Utility::GetValueByName('domains', $store->theme_id, $store->id);

    //     if ($enable_domain == 'on') {
    //         return 'https://' . $domains;
    //     } elseif ($enable_subdomain == 'on') {
    //         return 'https://' . $domains;
    //     } elseif ($enable_storelink) {
    //         return route('landing_page', $store->slug);
    //     } else {
    //         return route('landing_page', $store->slug);
    //     }
    // }

    // public function getOrderChart($arrParam)
    // {
    //     $user = auth()->user();
    //     if (!$user) {
    //         return redirect()->route('login')->with('message', __('You have been logged out.'));
    //     }
    //     $store = Store::where('id', $user->current_store)->first();

    //     if (!$store) {
    //         if (auth()->check()) {
    //             auth()->logout();
    //         }

    //         return redirect()->route('login')->with('message', __('You have been logged out.'));
    //     }
    //     // $userstore = $this->APP_THEME;

    //     $userstore = $store->theme_id ?? '';
    //     $arrDuration = [];
    //     if ($arrParam['duration']) {
    //         if ($arrParam['duration'] == 'week') {
    //             $previous_week = strtotime('-1 week +1 day');

    //             for ($i = 0; $i < 7; $i++) {
    //                 $arrDuration[date('Y-m-d', $previous_week)] = date('d-M', $previous_week);
    //                 $previous_week = strtotime(date('Y-m-d', $previous_week).' +1 day');
    //             }
    //         }
    //     }
    //     $arrTask = [];
    //     $arrTask['label'] = [];
    //     $arrTask['data'] = [];
    //     $registerTotal = '';
    //     $newguestTotal = '';
    //     foreach ($arrDuration as $date => $label) {
    //         if (auth()->user()->type == 'admin') {
    //             $data = Order::select(\DB::raw('count(*) as total'))
    //                 ->where('theme_id', $userstore)
    //                 ->where('store_id', getCurrentStore())
    //                 ->whereDate('created_at', '=', $date)
    //                 ->first();

    //             $registerTotal = Customer::select(\DB::raw('count(*) as total'))
    //                 ->where('theme_id', $userstore)
    //                 ->where('store_id', getCurrentStore())
    //                 ->where('regiester_date', '!=', null)
    //                 ->whereDate('regiester_date', '=', $date)
    //                 ->first();

    //             $newguestTotal = Customer::select(\DB::raw('count(*) as total'))
    //                 ->where('theme_id', $userstore)
    //                 ->where('store_id', getCurrentStore())
    //                 ->where('regiester_date', '=', null)
    //                 ->whereDate('last_active', '=', $date)
    //                 ->first();
    //         } else {
    //             $data = PlanOrder::select(\DB::raw('count(*) as total'))
    //                 ->whereDate('created_at', '=', $date)
    //                 ->first();
    //         }

    //         $arrTask['label'][] = $label;
    //         $arrTask['data'][] = $data ? $data->total : 0; // Check if $data is not null

    //         if (auth()->user()->isAbleTo('Manage Dashboard')) {
    //             $arrTask['registerTotal'][] = $registerTotal ? $registerTotal->total : 0; // Check if $registerTotal is not null
    //             $arrTask['newguestTotal'][] = $newguestTotal ? $newguestTotal->total : 0; // Check if $newguestTotal is not null
    //         }
    //     }

    //     return $arrTask;
    // }

    public function landing_page()
    {
        
        // $data = array (
        //     'currentTheme' => 'grocery',
        //     'pixelScript' => 
        //     array (
        //     ),
        //     'whatsapp_setting_enabled' => 0,
        //     'whatsapp_contact_number' => NULL,
        //     'theme_section' =>
        //     array (
        //       0 => 
        //       array (
        //         'id' => 1,
        //         'section_name' => 'header',
        //         'order' => 0,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       1 => 
        //       array (
        //         'id' => 2,
        //         'section_name' => 'slider',
        //         'order' => 1,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       2 => 
        //       array (
        //         'id' => 3,
        //         'section_name' => 'category',
        //         'order' => 2,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       3 => 
        //       array (
        //         'id' => 4,
        //         'section_name' => 'variant_background',
        //         'order' => 3,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       4 => 
        //       array (
        //         'id' => 5,
        //         'section_name' => 'bestseller_slider',
        //         'order' => 4,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       5 => 
        //       array (
        //         'id' => 6,
        //         'section_name' => 'product_category',
        //         'order' => 5,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       6 => 
        //       array (
        //         'id' => 7,
        //         'section_name' => 'best_product',
        //         'order' => 6,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       7 => 
        //       array (
        //         'id' => 8,
        //         'section_name' => 'best_product_second',
        //         'order' => 7,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       8 => 
        //       array (
        //         'id' => 9,
        //         'section_name' => 'product',
        //         'order' => 8,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       9 => 
        //       array (
        //         'id' => 10,
        //         'section_name' => 'product_banner_slider',
        //         'order' => 9,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       10 => 
        //       array (
        //         'id' => 11,
        //         'section_name' => 'logo_slider',
        //         'order' => 10,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       11 => 
        //       array (
        //         'id' => 12,
        //         'section_name' => 'best_selling_slider',
        //         'order' => 11,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       12 => 
        //       array (
        //         'id' => 13,
        //         'section_name' => 'newest_category',
        //         'order' => 12,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       13 => 
        //       array (
        //         'id' => 14,
        //         'section_name' => 'feature_product',
        //         'order' => 13,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       14 => 
        //       array (
        //         'id' => 15,
        //         'section_name' => 'background_image',
        //         'order' => 14,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       15 => 
        //       array (
        //         'id' => 16,
        //         'section_name' => 'modern_product',
        //         'order' => 15,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       16 => 
        //       array (
        //         'id' => 17,
        //         'section_name' => 'category_slider',
        //         'order' => 16,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       17 => 
        //       array (
        //         'id' => 18,
        //         'section_name' => 'service_section',
        //         'order' => 17,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       18 => 
        //       array (
        //         'id' => 19,
        //         'section_name' => 'subscribe',
        //         'order' => 18,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       19 => 
        //       array (
        //         'id' => 20,
        //         'section_name' => 'review',
        //         'order' => 19,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       20 => 
        //       array (
        //         'id' => 21,
        //         'section_name' => 'blog',
        //         'order' => 20,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       21 => 
        //       array (
        //         'id' => 22,
        //         'section_name' => 'articel_blog',
        //         'order' => 21,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       22 => 
        //       array (
        //         'id' => 23,
        //         'section_name' => 'top_product',
        //         'order' => 22,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       23 => 
        //       array (
        //         'id' => 24,
        //         'section_name' => 'video',
        //         'order' => 23,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //       24 => 
        //       array (
        //         'id' => 25,
        //         'section_name' => 'footer',
        //         'order' => 24,
        //         'is_hide' => 0,
        //         'store_id' => '2',
        //         'theme_id' => 'grocery',
        //         'created_at' => '2024-11-19T13:15:42.000000Z',
        //         'updated_at' => '2024-11-19T13:15:42.000000Z',
        //       ),
        //     ),
        //     'section' => 
        //     array (
        //       'header' => 
        //       array (
        //         'section_name' => 'Homepage - Header',
        //         'section_slug' => 'header',
        //         'unique_section_slug' => 'header',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Announcement Title',
        //             'slug' => 'announcement_text',
        //             'text' => 'Monday - Friday:</b> 8:00 AM - 9:00 PM',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here...',
        //           ),
        //           'support_title' => 
        //           array (
        //             'lable' => 'Support Title',
        //             'slug' => 'support_title',
        //             'text' => 'Support 24/7:',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here...',
        //           ),
        //           'support_value' => 
        //           array (
        //             'lable' => 'Support Value',
        //             'slug' => 'support_value',
        //             'text' => '+12 002-224-111',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here...',
        //           ),
        //           'menu_type' => 
        //           array (
        //             'lable' => 'Menu Type',
        //             'slug' => 'menu_type',
        //             'text' => 'menu_bar',
        //             'type' => 'select',
        //             'placeholder' => 'Please select..',
        //             'menu_ids' => 
        //             array (
        //             ),
        //           ),
        //         ),
        //       ),
        //       'slider' => 
        //         array(
        //         'section_name' => 'Homepage Slider',
        //         'section_slug' => 'slider',
        //         'unique_section_slug' => 'slider',
        //         'section_enable' => 'on',
        //         'array_type' => 'multi-inner-list',
        //         'loop_number' => 3,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Slider Title',
        //             'slug' => 'slider_title',
        //             'text' => 
        //             array (
        //               0 => 'Welcome to our store',
        //               1 => 'Welcome to our store',
        //               2 => 'Welcome to our store',
        //             ),
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here...',
        //           ),
        //           'sub_title' => 
        //           array (
        //             'lable' => 'Slider Sub Title',
        //             'slug' => 'slider_sub_title',
        //             'text' => 
        //             array (
        //               0 => ' Fall in love with </b> amazing aromas',
        //               1 => ' Fall in love with </b> amazing aromas',
        //               2 => ' Fall in love with </b> amazing aromas',
        //             ),
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here...',
        //           ),
        //           'description' => 
        //           array (
        //             'lable' => 'Slider Description',
        //             'slug' => 'slider_description',
        //             'text' => 
        //             array (
        //               0 => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy.',
        //               1 => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy.',
        //               2 => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy.',
        //             ),
        //             'type' => 'textarea',
        //             'placeholder' => 'Please enter here...',
        //           ),
        //           'button_first' => 
        //           array (
        //             'lable' => 'Slider First Button',
        //             'slug' => 'slider_first_button',
        //             'text' => 
        //             array (
        //               0 => 'Go to Shop',
        //               1 => 'Go to Shop',
        //               2 => 'Go to Shop',
        //             ),
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here...',
        //           ),
        //           'button_second' => 
        //           array (
        //             'lable' => 'Slider Second Button',
        //             'slug' => 'slider_second_button',
        //             'text' => 
        //             array (
        //               0 => 'Show more products',
        //               1 => 'Show more products',
        //               2 => 'Show more products',
        //             ),
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here...',
        //           ),
        //           'background_image' => 
        //           array (
        //             'lable' => 'Slider Background Image',
        //             'slug' => 'slider_background_image',
        //             'text' => 'themes/grocery/assets/images/banner-image.png',
        //             'image' => 'themes/grocery/assets/images/banner-image.png',
        //             'type' => 'file',
        //             'placeholder' => 'Please select file',
        //           ),
        //         ),
        //       ),
        //       'category' => 
        //       array (
        //         'section_name' => 'Category',
        //         'section_slug' => 'category',
        //         'unique_section_slug' => 'category',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Category Title',
        //             'slug' => 'category_title',
        //             'text' => 'Love our categories',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'button' => 
        //           array (
        //             'lable' => 'Category Button',
        //             'slug' => 'category_button',
        //             'text' => 'Show More Products',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'button_second' => 
        //           array (
        //             'lable' => 'Category Button',
        //             'slug' => 'category_button_second',
        //             'text' => 'Go to Category',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //         ),
        //       ),
        //       'variant_background' => 
        //       array (
        //         'section_name' => 'VariantBackground - Section',
        //         'section_slug' => 'variant_background',
        //         'unique_section_slug' => 'variant_background',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Variant Background Title',
        //             'slug' => 'variant_background_title',
        //             'text' => 'Fruits </b>& Vegetables',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'sub_title' => 
        //           array (
        //             'lable' => 'Variant Background Lable',
        //             'slug' => 'variant_background_sub_title',
        //             'text' => 'Daily Discounts',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'description' => 
        //           array (
        //             'lable' => 'Variant Background Description',
        //             'slug' => 'variant_background_description',
        //             'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
        //             'type' => 'textarea',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'button' => 
        //           array (
        //             'lable' => 'Variant Background Button',
        //             'slug' => 'variant_background_button',
        //             'text' => 'Show Products',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'image' => 
        //           array (
        //             'lable' => 'Varinat Background Image',
        //             'slug' => 'variant_background_image',
        //             'text' => 'themes/grocery/assets/images/green-mandarines.png',
        //             'image' => 'themes/grocery/assets/images/green-mandarines.png',
        //             'type' => 'photoupload',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //         ),
        //       ),
        //       'bestseller_slider' => 
        //       array (
        //         'section_name' => 'Bestseller - Slider',
        //         'section_slug' => 'bestseller_slider',
        //         'unique_section_slug' => 'bestseller_slider',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Bestseller Title',
        //             'slug' => 'bestseller_text',
        //             'text' => ' Top </b> Products',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'button' => 
        //           array (
        //             'lable' => 'Bestseler Button',
        //             'slug' => 'bestseller_button',
        //             'text' => 'Show more products',
        //             'type' => 'button',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'product_type' => 
        //           array (
        //             'lable' => 'Product Type',
        //             'slug' => 'product_type',
        //             'text' => 'latest_product',
        //             'type' => 'select',
        //             'placeholder' => 'Please select..',
        //             'product_ids' => 
        //             array (
        //             ),
        //           ),
        //           'category_list' => 
        //           array (
        //             'lable' => 'Product Category Button',
        //             'slug' => 'product_category_list',
        //             'text' => '',
        //             'type' => 'select',
        //             'placeholder' => 'Please select..',
        //             'category_ids' => 
        //             array (
        //             ),
        //           ),
        //         ),
        //       ),
        //       'product_category' => 
        //       array (
        //         'section_name' => 'Product - Category',
        //         'section_slug' => 'product_category',
        //         'unique_section_slug' => 'product_category',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Product Category Title',
        //             'slug' => 'product_category_title',
        //             'text' => 'Our Bestsellers </b>',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'button' => 
        //           array (
        //             'lable' => 'Product Category Button',
        //             'slug' => 'product_category_button',
        //             'text' => 'Go to products',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'category_list' => 
        //           array (
        //             'lable' => 'Product Category Button',
        //             'slug' => 'product_category_list',
        //             'text' => '',
        //             'type' => 'select',
        //             'placeholder' => 'Please select..',
        //             'category_ids' => 
        //             array (
        //             ),
        //           ),
        //         ),
        //       ),
        //       'best_product' => 
        //       array (
        //         'section_name' => 'Best - Product',
        //         'section_slug' => 'best_product',
        //         'unique_section_slug' => 'best_product',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Best Product Title',
        //             'slug' => 'best_product_titel',
        //             'text' => 'Our Loved category </b>',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'button' => 
        //           array (
        //             'lable' => 'Button',
        //             'slug' => 'best_product_button',
        //             'text' => 'Go to product',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'button_first' => 
        //           array (
        //             'lable' => 'Button',
        //             'slug' => 'best_product_button_first',
        //             'text' => 'Go to catrgory',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'sub_title' => 
        //           array (
        //             'lable' => ' Sub Title',
        //             'slug' => 'best_product_subtitle',
        //             'text' => 'Vegetables',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'description' => 
        //           array (
        //             'lable' => 'Description',
        //             'slug' => 'best_product_description',
        //             'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
        //             'type' => 'textarea',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'image' => 
        //           array (
        //             'lable' => 'Image',
        //             'slug' => 'best_product_image',
        //             'text' => 'themes/grocery/assets/images/vegetables-2.jpg',
        //             'image' => 'themes/grocery/assets/images/vegetables-2.jpg',
        //             'type' => 'file',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //         ),
        //       ),
        //       'best_product_second' => 
        //       array (
        //       ),
        //       'product' => 
        //       array (
        //         'section_name' => 'Product',
        //         'section_slug' => 'product',
        //         'unique_section_slug' => 'product',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Product Title',
        //             'slug' => 'product_title',
        //             'text' => 'Our Products',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'button' => 
        //           array (
        //             'lable' => 'Product Button',
        //             'slug' => 'product_button',
        //             'text' => 'Go to products',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'description' => 
        //           array (
        //             'lable' => 'Product Description',
        //             'slug' => 'product_description',
        //             'text' => 'They\'re made from botanically pure ingredients, so you can feel good about eating them. Plus, they\'re really nutritious, so you can feel good too.',
        //             'type' => 'textarea',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //         ),
        //       ),
        //       'product_banner_slider' => 
        //       array (
        //         'section_name' => 'Product - Banner',
        //         'section_slug' => 'product_banner_slider',
        //         'unique_section_slug' => 'product_banner_slider',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Title',
        //             'slug' => 'product_banner_slider_title',
        //             'text' => 'Fall in love with </b>amazing clothes',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'sub_title' => 
        //           array (
        //             'lable' => 'Sub Title',
        //             'slug' => 'product_banner_slider_sub_title',
        //             'text' => 'Fall in love with </b>amazing clothes',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'description' => 
        //           array (
        //             'lable' => 'Description',
        //             'slug' => 'product_banner_slider_description',
        //             'text' => 'Fall in love with </b>amazing clothes',
        //             'type' => 'textarea',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'button' => 
        //           array (
        //             'lable' => 'Button',
        //             'slug' => 'product_banner_slider_button',
        //             'text' => 'Go to products',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //         ),
        //       ),
        //       'logo_slider' => 
        //       array (
        //         'section_name' => 'Homepage Logo Slider',
        //         'section_slug' => 'logo_slider',
        //         'unique_section_slug' => 'logo_slider',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'image' => 
        //           array (
        //             'lable' => 'logo_slider Image',
        //             'slug' => 'logo_slider_image',
        //             'text' => 
        //             array (
        //               0 => 'themes/babycare/assets/images/banner-image.png',
        //             ),
        //             'image' => 
        //             array (
        //               0 => 'themes/babycare/assets/images/banner-image.png',
        //             ),
        //             'type' => 'file',
        //             'placeholder' => 'Please select file',
        //           ),
        //         ),
        //       ),
        //       'best_selling_slider' => 
        //       array (
        //       ),
        //       'newest_category' => 
        //       array (
        //         'section_name' => 'Newest - Category',
        //         'section_slug' => 'newest_category',
        //         'unique_section_slug' => 'newest_category',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'button' => 
        //           array (
        //             'lable' => 'Newest Category Button',
        //             'slug' => 'newest_category_button',
        //             'text' => 'Go to products',
        //             'type' => 'button',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //         ),
        //       ),
        //       'feature_product' => 
        //       array (
        //         'section_name' => 'Feature - Product',
        //         'section_slug' => 'feature_product',
        //         'unique_section_slug' => 'feature_product',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Feature - Product Title',
        //             'slug' => 'feature_product_title',
        //             'text' => 'A beautiful scent',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here...',
        //           ),
        //           'button' => 
        //           array (
        //             'lable' => 'Feature - Product Button',
        //             'slug' => 'feature_product_button',
        //             'text' => 'Go to products',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here...',
        //           ),
        //         ),
        //       ),
        //       'background_image' => 
        //       array (
        //         'section_name' => 'BackgroundImage - Section',
        //         'section_slug' => 'background_image',
        //         'unique_section_slug' => 'background_image',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Background Image Title',
        //             'slug' => 'background_image_title',
        //             'text' => 'Fall in love with </b>amazing clothes',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'description' => 
        //           array (
        //             'lable' => 'Background Image Description',
        //             'slug' => 'background_image_description',
        //             'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
        //             'type' => 'textarea',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'button' => 
        //           array (
        //             'lable' => 'Background Image Button',
        //             'slug' => 'background_image_button',
        //             'text' => 'Go to Shop',
        //             'type' => 'button',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'image' => 
        //           array (
        //             'lable' => 'Background Image',
        //             'slug' => 'background_image',
        //             'text' => 'themes/sensation/assets/images/banner-2.png',
        //             'image' => 'themes/sensation/assets/images/banner-2.png',
        //             'type' => 'photoupload',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //         ),
        //       ),
        //       'modern_product' => 
        //       array (
        //         'section_name' => 'Modern - Product',
        //         'section_slug' => 'modern_product',
        //         'unique_section_slug' => 'modern_product',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Modern Product Title',
        //             'slug' => 'modern_product_titel',
        //             'text' => 'Fall in love with </b>amazing clothes',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'sub_title' => 
        //           array (
        //             'lable' => 'Modern Product Sub Title',
        //             'slug' => 'modern_product_sub_title',
        //             'text' => ' Show </b> more product',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'button' => 
        //           array (
        //             'lable' => 'Modern Product Button',
        //             'slug' => 'modern_product_button',
        //             'text' => 'Go to products',
        //             'type' => 'button',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //         ),
        //       ),
        //       'category_slider' => 
        //       array (
        //         'section_name' => 'Category - Slider',
        //         'section_slug' => 'category_slider',
        //         'unique_section_slug' => 'category_slider',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Category Slider Title',
        //             'slug' => 'category_slider_title',
        //             'text' => 'Fall in love with </b>amazing clothes',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'description' => 
        //           array (
        //             'lable' => 'Category Slider Description',
        //             'slug' => 'category_slider_description',
        //             'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
        //             'type' => 'textarea',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'category_list' => 
        //           array (
        //             'lable' => 'Category Slider List',
        //             'slug' => 'category_slider_list',
        //             'text' => '',
        //             'type' => 'select',
        //             'placeholder' => 'Please select..',
        //             'category_ids' => 
        //             array (
        //             ),
        //           ),
        //         ),
        //       ),
        //       'service_section' => 
        //       array (
        //         'section_name' => 'Service Section',
        //         'section_slug' => 'service_section',
        //         'unique_section_slug' => 'service_section',
        //         'section_enable' => 'on',
        //         'array_type' => 'multi-inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Service Section Title',
        //             'slug' => 'service_section_title',
        //             'text' => 
        //             array (
        //               0 => 'SHIPPING',
        //             ),
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here...',
        //           ),
        //           'sub_title' => 
        //           array (
        //             'lable' => 'Service Section Sub Title',
        //             'slug' => 'service_section_sub_title',
        //             'text' => 
        //             array (
        //               0 => 'Free worldwideshopping',
        //             ),
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here...',
        //           ),
        //           'background_image' => 
        //           array (
        //             'lable' => 'Service Section Image',
        //             'slug' => 'service_section_image',
        //             'text' => 'themes/sensation/assets/images/banner.png',
        //             'image' => 'themes/sensation/assets/images/banner.png',
        //             'type' => 'file',
        //             'placeholder' => 'Please select file',
        //           ),
        //         ),
        //       ),
        //       'subscribe' => 
        //       array (
        //         'section_name' => 'Subscribe - Section',
        //         'section_slug' => 'subscribe',
        //         'unique_section_slug' => 'subscribe',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Subscribe Title',
        //             'slug' => 'subscribe_title',
        //             'text' => ' Subscribe and get </b> -20% off',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'description' => 
        //           array (
        //             'lable' => 'Subscribe Description',
        //             'slug' => 'subscribe_description',
        //             'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
        //             'type' => 'textarea',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'button' => 
        //           array (
        //             'lable' => 'Subscribe Button',
        //             'slug' => 'subscribe_button',
        //             'text' => 'Subscribe',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'sub_title' => 
        //           array (
        //             'lable' => 'Subscribe Sub Title',
        //             'slug' => 'subscribe_sub_title',
        //             'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'image' => 
        //           array (
        //             'lable' => 'Subscribe Image',
        //             'slug' => 'subscribe_image',
        //             'text' => 'themes/sensation/assets/images/sub-banner.jpg',
        //             'image' => 'themes/sensation/assets/images/sub-banner.jpg',
        //             'type' => 'file',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //         ),
        //       ),
        //       'review' => 
        //       array (
        //         'section_name' => 'Review',
        //         'section_slug' => 'review',
        //         'unique_section_slug' => 'review',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Review Title',
        //             'slug' => 'review_title',
        //             'text' => ' Testimonials</b>',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'description' => 
        //           array (
        //             'lable' => 'Review Description',
        //             'slug' => 'review_description',
        //             'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy.Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
        //             'type' => 'textarea',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'button' => 
        //           array (
        //             'lable' => 'Review Button',
        //             'slug' => 'review_button',
        //             'text' => 'Show products',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //         ),
        //       ),
        //       'blog' => 
        //       array (
        //         'section_name' => 'Blog',
        //         'section_slug' => 'blog',
        //         'unique_section_slug' => 'blog',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'title' => 
        //           array (
        //             'lable' => 'Blog Title',
        //             'slug' => 'blog_title',
        //             'text' => ' About </b> the blog',
        //             'type' => 'text',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'description' => 
        //           array (
        //             'lable' => 'Blog Description',
        //             'slug' => 'blog_description',
        //             'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
        //             'type' => 'textarea',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //         ),
        //       ),
        //       'articel_blog' => 
        //       array (
        //       ),
        //       'top_product' => 
        //       array (
        //       ),
        //       'video' => 
        //       array (
        //       ),
        //       'footer' => 
        //       array (
        //         'section_name' => 'Footer - Section',
        //         'section_slug' => 'footer',
        //         'unique_section_slug' => 'footer',
        //         'section_enable' => 'on',
        //         'array_type' => 'inner-list',
        //         'loop_number' => 1,
        //         'section' => 
        //         array (
        //           'description' => 
        //           array (
        //             'lable' => 'Footer Section Description',
        //             'slug' => 'footer_description',
        //             'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy.',
        //             'type' => 'textarea',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'footer_link' => 
        //           array (
        //             'lable' => 'Footer Links',
        //             'slug' => 'footer_links',
        //             'text' => 'Footer Links',
        //             'type' => 'array',
        //             'loop_number' => 4,
        //             'social_link' => 
        //             array (
        //               0 => 'https://www.youtube.com/',
        //               1 => 'https://www.facebook.com/',
        //               2 => 'https://www.instagrm.com/',
        //               3 => 'https://www.twitter.com/',
        //             ),
        //             'social_icon' => 
        //             array (
        //               0 => 
        //               array (
        //                 'text' => 'themes/grocery/assets/images/youtube.png',
        //                 'image' => 'themes/grocery/assets/images/youtube.png',
        //               ),
        //               1 => 
        //               array (
        //                 'text' => 'themes/grocery/assets/images/facebook.png',
        //                 'image' => 'themes/grocery/assets/images/facebook.png',
        //               ),
        //               2 => 
        //               array (
        //                 'text' => 'themes/grocery/assets/images/insta.png',
        //                 'image' => 'themes/grocery/assets/images/insta.png',
        //               ),
        //               3 => 
        //               array (
        //                 'text' => 'themes/grocery/assets/images/twitter.png',
        //                 'image' => 'themes/grocery/assets/images/twitter.png',
        //               ),
        //             ),
        //           ),
        //           'footer_menu_type' => 
        //           array (
        //             'lable' => 'Footer Menu Type',
        //             'slug' => 'footer_menu_type',
        //             'text' => 'footer_menu_bar',
        //             'type' => 'array',
        //             'loop_number' => 3,
        //             'footer_menu_ids' => 
        //             array (
        //             ),
        //           ),
        //           'copy_right' => 
        //           array (
        //             'lable' => 'Copy Right',
        //             'slug' => 'footer_copy_right',
        //             'text' => '© 2022 Foodmart. All rights reserved',
        //             'type' => 'textarea',
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'privacy_policy' => 
        //           array (
        //             'lable' => 'Policy Privacy',
        //             'slug' => 'footer_privacy_policy',
        //             'text' => 'Policy Privacy',
        //             'type' => 'text',
        //             'link' => NULL,
        //             'placeholder' => 'Please enter here..',
        //           ),
        //           'terms_and_conditions' => 
        //           array (
        //             'lable' => 'Terms and conditions',
        //             'slug' => 'footer_terms_and_conditions',
        //             'text' => 'Terms and conditions',
        //             'type' => 'text',
        //             'link' => NULL,
        //             'placeholder' => 'Please enter here..',
        //           ),
        //         ),
        //       ),
        //     ),
        //     'setting' => 
        //     array (
        //       'logo_dark' => 'storage/uploads/logo/logo-dark.png',
        //       'logo_light' => 'storage/uploads/logo/logo-light.png',
        //       'favicon' => 'storage/uploads/logo/favicon.png',
        //       'title_text' => 'ecom',
        //       'footer_text' => 'Copyright © ecom',
        //       'site_date_format' => 'M j, Y',
        //       'site_time_format' => 'g:i A',
        //       'SITE_RTL' => 'off',
        //       'display_landing' => 'off',
        //       'SIGNUP' => 'off',
        //       'email_verification' => 'off',
        //       'color' => 'theme-4',
        //       'cust_theme_bg' => 'on',
        //       'cust_darklayout' => 'off',
        //       'CURRENCY_NAME' => 'USD',
        //       'CURRENCYCURRENCY' => '$',
        //       'currency_format' => '1',
        //       'defult_currancy' => 'USD',
        //       'defult_language' => 'en',
        //       'defult_timezone' => 'Asia/Kolkata',
        //       'enable_cookie' => 'on',
        //       'cookie_logging' => 'on',
        //       'necessary_cookies' => 'on',
        //       'cookie_title' => 'We use cookies!',
        //       'cookie_description' => 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it',
        //       'strictly_cookie_title' => 'Strictly necessary cookies',
        //       'strictly_cookie_description' => 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly',
        //       'more_information_description' => 'For any queries in relation to our policy on cookies and your choices, please contact us',
        //       'more_information_title' => '',
        //       'contactus_url' => '#',
        //       '_token' => 'aEh0zcmeJhBxBjaIu6WqjLdvujNcs7JM0ZXBx72k',
        //       'custom_color' => '#000000',
        //       'color_flag' => 'false',
        //       'taxes' => 'off',
        //     ),
        //     'theme_logo' => 'storage/uploads/logo/logo.png',
        //     'currantLang' => 'en',
        //     'stringid' => 2,
        //     'languages' => 
        //     array (
        //       'ar' => 'Arabic',
        //       'da' => 'Danish',
        //       'de' => 'German',
        //       'en' => 'English',
        //       'es' => 'Spanish',
        //       'fr' => 'French',
        //       'it' => 'Italian',
        //       'ja' => 'Japanese',
        //       'nl' => 'Dutch',
        //       'pl' => 'Polish',
        //       'pt' => 'Portuguese',
        //       'ru' => 'Russian',
        //       'tr' => 'Turkish',
        //       'zh' => 'Chinese',
        //       'he' => 'Hebrew',
        //       'pt-br' => 'Portuguese(Brazil)',
        //     ),
        //     'currency' => '$',
        //     'SITE_RTL' => NULL,
        //     'color' => 'theme-3',
        //     'is_publish' => true,
        //     'slug' => 'grocery',
        //     'store' => 
        //     array (
        //       'id' => 2,
        //       'name' => 'grocery',
        //       'email' => 'admin@example.com',
        //       'theme_id' => 'grocery',
        //       'slug' => 'grocery',
        //       'default_language' => 'en',
        //       'created_by' => 2,
        //       'is_active' => 1,
        //       'enable_pwa_store' => 'off',
        //       'created_at' => '2024-11-19T13:15:42.000000Z',
        //       'updated_at' => '2024-12-19T13:38:21.000000Z',
        //     ),
        //     'theme_id' => 'grocery',
        //     'category_options' => 
        //     array (
        //       0 => 'All Products',
        //       1 => 'mian',
        //     ),
        //     'store_id' => 2,
        //     'topNavItems' => '',
        //     'products' => 
        //     array (
        //     ),
        //     'tax_option' => 
        //     array (
        //     ),
        //     'theme_favicon' => 'https://demo.tgnu.tj/ecom/storage/uploads/logo/Favicon.png',
        //     'theme_favicons' => 'https://demo.tgnu.tj/ecom/storage/uploads/logo/Favicon.png',
        //     'google_analytic' => NULL,
        //     'storejs' => NULL,
        //     'storecss' => NULL,
        //     'fbpixel_code' => NULL,
        //     'metaimage' => 'https://demo.tgnu.tj/ecom/themes/grocery/theme_img/img_1.png',
        //     'metadesc' => NULL,
        //     'metakeyword' => NULL,
        //     'currency_icon' => '$',
        //     'theme_image' => 'https://demo.tgnu.tj/ecom/themes/grocery/theme_img/img_1.png',
        //     'pages' => 
        //     array (
        //     ),
        //     'categories' => 
        //     array (
        //     ),
        //     'latest_product' => NULL,
        //     'landing_product' => NULL,
        //     'search_products' => 
        //     array (
        //       1 => 'cat1',
        //     ),
        //     'MainCategoryList' => 
        //     array (
        //     ),
        //     'SubCategoryList' => 
        //     array (
        //       0 => 
        //       array (
        //         'id' => 1,
        //         'name' => 'sabzi',
        //         'image_url' => 'https://demo.tgnu.tj/ecom/storage/uploads/default.jpg',
        //         'image_path' => '/storage/uploads/default.jpg',
        //         'icon_path' => '/storage/uploads/default.jpg',
        //         'maincategory_id' => 1,
        //         'status' => 1,
        //         'theme_id' => 'grocery',
        //         'store_id' => 2,
        //         'created_at' => '2024-12-19T13:40:10.000000Z',
        //         'updated_at' => '2024-12-19T13:40:10.000000Z',
        //         'icon_img_path' => '/storage/uploads/default.jpg',
        //         'image_path_full_url' => 'https://demo.tgnu.tj/ecom/storage/uploads/default.jpg',
        //         'icon_path_full_url' => 'https://demo.tgnu.tj/ecom/storage/uploads/default.jpg',
        //       ),
        //     ),
        //     'reviews' => 
        //     array (
        //     ),
        //     'category_id' => 
        //     array (
        //     ),
        //     'has_subcategory' => 0,
        //     'discount_products' => 
        //     array (
        //     ),
        //     'all_products' => 
        //     array (
        //     ),
        //     'modern_products' => 
        //     array (
        //     ),
        //     'home_products' => 
        //     array (
        //     ),
        //     'home_page_products' => 
        //     array (
        //     ),
        //     'random_product' => NULL,
        //     'bestSeller' => 
        //     array (
        //     ),
        //     'all_slider_products' => 
        //     array (
        //     ),
        // );
        // // $data = (object)$data; 
        // // $data->section = $data->section; 
        // foreach ($data['section'] as $key => $value) {
        //     $data['section'][$key] = (object)$value;
        // }
        // // dd($data);
        

        // return view('main_file', $data);
    }


    

    // public function faqs_page(Request $request, $storeSlug)
    // {
    //     $store = Cache::remember('store_' . $storeSlug, 3600, function () use ($storeSlug) {
    //         return Store::where('slug', $storeSlug)->first();
    //     });
    //     if (!$store) {
    //         abort(404);
    //     }
    //     $currentTheme = $store->theme_id;
    //     $slug = $store->slug;
    //     Theme::set($currentTheme);
    //     $languages = Utility::languages();
    //     $faqs = Faq::where('theme_id', $currentTheme)->where('store_id', $store->id)->get();
    //     $currantLang = \Cookie::get('LANGUAGE') ?? $store->default_language;
    //     $data = getThemeSections($currentTheme, $storeSlug, true, true);
    //     // Get Data from database
    //     $sqlData = getHomePageDatabaseSectionDataFromDatabase($data);
    //     $section = (object) $data['section'];
    //     $topNavItems = [];
    //     $menu_id = (array) $section->header->section->menu_type->menu_ids ??
    //     [];
    //     $topNavItems = get_nav_menu($menu_id);
    //     $page_json = arrayToObject(getInnerPageJson($currentTheme, $store->id, 'faq_page'));

    //     return view('front_end.sections.pages.faq_page_section', compact('faqs', 'currentTheme', 'currantLang', 'store', 'section', 'topNavItems', 'page_json') + $data + $sqlData);
    // }

    // public function blog_page(Request $request, $storeSlug)
    // {
    //     $store = Cache::remember('store_' . $storeSlug, 3600, function () use ($storeSlug) {
    //         return Store::where('slug', $storeSlug)->first();
    //     });
    //     if (!$store) {
    //         abort(404);
    //     }
    //     $store_id = $store->id;
    //     $slug = $store->slug;
    //     $currentTheme = $store->theme_id;
    //     Theme::set($currentTheme);
    //     $currantLang = \Cookie::get('LANGUAGE') ?? $store->default_language;

    //     $data = getThemeSections($currentTheme, $storeSlug, true, true);

    //     $section = (object) $data['section'];
    //     // Get Data from database
    //     $sqlData = getHomePageDatabaseSectionDataFromDatabase($data);
    //     $topNavItems = [];
    //     $menu_id = (array) $section->header->section->menu_type->menu_ids ??
    //     [];
    //     $topNavItems = get_nav_menu($menu_id);

    //     $BlogCategory = BlogCategory::where('theme_id', $currentTheme)->where('store_id', $store_id)->get()->pluck('name', 'id');
    //     $BlogCategory->prepend('All', '0');

    //     $blogs = Blog::where('theme_id', $currentTheme)->where('store_id', $store_id)->get();
    //     $page_json = arrayToObject(getInnerPageJson($currentTheme, $store->id, 'blog_page'));

    //     return view('front_end.sections.pages.blog_page_section', compact('BlogCategory', 'currentTheme', 'currantLang', 'store', 'section', 'topNavItems', 'blogs', 'page_json') + $data + $sqlData);
    // }

    // public function article_page(Request $request, $storeSlug, $id)
    // {
    //     $store = Cache::remember('store_' . $storeSlug, 3600, function () use ($storeSlug) {
    //         return Store::where('slug', $storeSlug)->first();
    //     });
    //     if (!$store) {
    //         abort(404);
    //     }
    //     $store_id = $store->id;
    //     $slug = $store->slug;
    //     $currentTheme = $store->theme_id;
    //     Theme::set($currentTheme);
    //     $blogs = Blog::where('id', $id)->where('store_id', $store_id)->get();
    //     $home_blogs = Blog::where('store_id', $store_id)->get();
    //     if ($blogs->isEmpty()) {
    //         abort(404);
    //     }

    //     $datas = Blog::where('theme_id', $currentTheme)->where('store_id', $store_id)->inRandomOrder()
    //         ->limit(3)
    //         ->get();

    //     $l_articles = Blog::where('theme_id', $currentTheme)->where('store_id', $store_id)->inRandomOrder()
    //         ->limit(5)
    //         ->get();

    //     $BlogCategory = BlogCategory::where('theme_id', $currentTheme)->where('store_id', $store_id)->get()->pluck('name', 'id');
    //     $BlogCategory->prepend('All Products', '0');
    //     $homeproducts = Product::where('theme_id', $currentTheme)->where('product_type', null)->where('store_id', $store_id)->get();
    //     $currantLang = \Cookie::get('LANGUAGE') ?? $store->default_language;
    //     $blog1 = Blog::where('theme_id', $currentTheme)->where('store_id', $store_id)->get();

    //     $data = getThemeSections($currentTheme, $storeSlug, true, true);
    //     $section = (object) $data['section'];
    //     // Get Data from database
    //     $sqlData = getHomePageDatabaseSectionDataFromDatabase($data);
    //     $topNavItems = [];
    //     $menu_id = (array) $section->header->section->menu_type->menu_ids ??
    //     [];
    //     $topNavItems = get_nav_menu($menu_id);

    //     $page_json = arrayToObject(getInnerPageJson($currentTheme, $store->id, 'article_page'));

    //     return view('front_end.sections.pages.article', compact('currantLang', 'currentTheme', 'blogs', 'datas', 'l_articles', 'BlogCategory', 'homeproducts', 'blog1', 'section', 'topNavItems', 'home_blogs', 'page_json') + $data + $sqlData);

    // }

    // public function product_page(Request $request, $storeSlug, $categorySlug = null)
    // {
    //     $store = Cache::remember('store_' . $storeSlug, 3600, function () use ($storeSlug) {
    //         return Store::where('slug', $storeSlug)->first();
    //     });
    //     if (!$store) {
    //         abort(404);
    //     }

    //     $store_id = $store->id;
    //     $slug = $store->slug;
    //     $currentTheme = $store->theme_id;
    //     $category_ids = [];
    //     $brand_ids = [];
    //     if ($categorySlug) {
    //         $category_ids = MainCategory::where(function($query) use ($categorySlug) {
    //             $query->where('slug', 'Like', "%$categorySlug%")->orWhere('name', 'Like', "%$categorySlug%");
    //         })->where('theme_id', $currentTheme)->where('store_id',$store_id)->pluck('id')->toArray();
    //         if(!$category_ids)
    //         {
    //             $brand_ids = ProductBrand::where('slug', 'like', $categorySlug)->where('theme_id', $currentTheme)->where('store_id',$store_id)->pluck('id')->toArray();
    //         }
    //     }
    //     Theme::set($currentTheme);
    //     $languages = Utility::languages();
    //     $faqs = Faq::where('theme_id', $currentTheme)->where('store_id', $store_id)->get();
    //     $currantLang = \Cookie::get('LANGUAGE') ?? $store->default_language;
    //     $data = getThemeSections($currentTheme, $storeSlug, true, true);
    //     $section = (object) $data['section'];
    //     // Get Data from database
    //     $sqlData = getHomePageDatabaseSectionDataFromDatabase($data);
    //     $topNavItems = [];
    //     $menu_id = (array) $section->header->section->menu_type->menu_ids ??
    //     [];
    //     $topNavItems = get_nav_menu($menu_id);

    //     $filter_product = $request->filter_product;
    //     $MainCategoryList = MainCategory::where('status', 1)->where('theme_id', $currentTheme)->where('store_id', $store_id)->get();
    //     $SubCategoryList = SubCategory::where('status', 1)->where('theme_id', $currentTheme)->where('store_id', $store_id)->get();
    //     $filter_tag = $SubCategoryList;
    //     $has_subcategory = Utility::ThemeSubcategory($currentTheme);
    //     $search_products = Product::where('theme_id', $currentTheme)->where('store_id', $store_id)->get()->pluck('name', 'id');
    //     $ApiController = new ApiController();

    //     $featured_products_data = $ApiController->featured_products($request, $store->slug);
    //     $featured_products = $featured_products_data->getData();
    //     $brands = ProductBrand::where('status', 1)->where('theme_id', $currentTheme)->where('store_id', $store_id)->get();
    //     if (!$has_subcategory) {
    //         $filter_tag = $MainCategoryList;
    //     }
    //     $sub_category_select = $brand_select = [];
    //     $main_category = $request->main_category;
    //     $category_slug = $request->category_slug;
    //     $sub_category = $request->sub_category;
    //     $product_brand = $request->brands;
    //     if (!empty($main_category)) {
    //         if (!$has_subcategory) {
    //             $sub_category_select = MainCategory::where('id', $main_category)->pluck('id')->toArray();
    //         } else {
    //             $sub_category_select = SubCategory::where('maincategory_id', $main_category)->pluck('id')->toArray();
    //         }
    //     }

    //     if (!empty($product_brand)) {
    //         $brand_select = ProductBrand::where('id', $product_brand)->pluck('id')->toArray();
    //     }

    //     if (is_array($sub_category_select) && count($sub_category_select) == 0 && isset($category_slug)) {
    //         $sub_category_select = MainCategory::where('slug', $category_slug)->pluck('id')->toArray();
    //     }
    //     if (!empty($sub_category)) {
    //         $sub_category_select = [];
    //         $sub_category_select[] = $sub_category;
    //     }
    //     // bestseller
    //     $per_page = '12';
    //     $destination = 'web';
    //     $bestSeller_fun = Product::bestseller_guest($currentTheme, $store_id, $per_page, $destination);
    //     $bestSeller = [];
    //     if ($bestSeller_fun['status'] == 'success') {
    //         $bestSeller = $bestSeller_fun['bestseller_array'];
    //     }

    //     $products_query = Product::where('theme_id', $currentTheme)->where('product_type', null)->where('store_id', $store_id)->where('status', 1);
    //     if (!empty($main_category)) {
    //         $products_query->where('maincategory_id', $main_category);
    //     }
    //     if (!empty($sub_category)) {
    //         $products_query->where('subcategory_id', $sub_category);
    //     }
    //     if (count($category_ids) > 0) {
    //         $products_query->whereIn('maincategory_id', $category_ids);
    //     }

    //     if (!empty($product_brand)) {
    //         $products_query->where('brand_id', $product_brand);
    //     }

    //     $product_count = $products_query->count();
    //     $products = $products_query->get();

    //     /* For Filter */
    //     $min_price = 0;
    //     $max_price = Product::where('variant_product', 0)->orderBy('price', 'DESC')->where('product_type', null)->where('theme_id', $currentTheme)->where('store_id', $store_id)->first();
    //     $max_price = !empty($max_price->price) ? $max_price->price : '0';

    //     $currency_icon = $currency = Utility::GetValueByName('defult_currancy_symbol', $store->theme_id, $store->id);
    //     if (empty($currency)) {
    //         $currency_icon = $currency = '$';
    //     }

    //     $MainCategory = MainCategory::where('theme_id', $currentTheme)->where('store_id', $store_id)->get()->pluck('name', 'id');
    //     $MainCategory->prepend('All Products', '0');
    //     $homeproducts = Product::where('theme_id', $currentTheme)->where('product_type', null)->where('store_id', $store_id)->get();

    //     $product_list = Product::orderBy('created_at', 'asc')->where('theme_id', $currentTheme)->where('store_id', $store->id)->limit(4)->get();

    //     $product_tag = implode(',', $category_ids);
    //     $product_brand = implode(',', $brand_ids);

    //     $page_json = arrayToObject(getInnerPageJson($currentTheme, $store->id, 'collection_page'));
    //     $compact = ['slug','MainCategoryList','SubCategoryList','bestSeller','currency', 'currency_icon', 'min_price', 'max_price','product_count','has_subcategory','filter_tag','search_products','sub_category_select','featured_products','filter_product','MainCategory','homeproducts', 'products','product_list', 'brands', 'brand_select', 'product_tag', 'page_json','product_brand','store'];

    //     return view('front_end.sections.pages.product_list', compact($compact) + $data + $sqlData);
    // }

    // public function product_page_filter(Request $request, $storeSlug)
    // {
    //     $store = Cache::remember('store_' . $storeSlug, 3600, function () use ($storeSlug) {
    //         return Store::where('slug', $storeSlug)->first();
    //     });
    //     if (!$store) {
    //         return redirect()->back()->with('error', __('Something went wrong!'));
    //     }
    //     $theme_id = $currentTheme = $store->theme_id;
    //     $store_id = $store->id;
    //     $slug = $storeSlug;
    //     Theme::set($store->theme_id);
    //     $has_subcategory = Utility::ThemeSubcategory($currentTheme);
    //     if ($request->ajax()) {
    //         $page = $request->page;
    //         $filter_value = $request->filter_product;
    //         $product_tag = $request->product_tag;
    //         $min_price = $request->min_price;
    //         $max_price = $request->max_price;
    //         $rating = $request->rating;

    //     } else {
    //         $page = $request->query('page', 1);
    //         $filter_value = $request->query('filter_product');
    //         $product_tag = $request->query('product_tag');
    //         $min_price = $request->query('min_price');
    //         $max_price = $request->query('max_price');
    //         $rating = $request->query('rating');
    //         // $queryParams = $request->query();
    //         // $page = 1;
    //     }
    //     $filter_value = $request->filter_product;
    //     $product_tag = $request->product_tag;
    //     $product_brand = $request->product_brand;
    //     $min_price = $request->min_price;
    //     $max_price = $request->max_price;
    //     $rating = $request->rating;

    //     if(!empty($product_tag))
    //     {
    //         $tag = $product_tag;
    //         $product_tag = explode(',', $tag);
    //     }

    //     $products_query = Product::where('theme_id', $theme_id)->where('product_type', null)->where('store_id', $store_id)->where('status', 1);
    //     if (!empty($product_tag)) {
    //         if (!$has_subcategory) {
    //             $products_query->whereIn('maincategory_id', $product_tag);
    //         } else {
    //             $products_query->whereIn('subcategory_id', $product_tag);
    //         }
    //     }

    //     if (!empty($product_brand)) {
    //         $productBrandIds = explode(',', $product_brand);
    //         $products_query->whereIn('brand_id', $productBrandIds);
    //     }
    //     if (!empty($max_price)) {
    //         $products_query->whereBetween('price', [$min_price, $max_price]);
    //     }
    //     if (!empty($rating) && $rating != 'undefined') {
    //         $products_query->where('average_rating', $rating);
    //     }
    //     if (!empty($filter_value)) {
    //         if ($filter_value == 'best-selling') {
    //             // $products_query->where('tag_api','best seller');
    //         }
    //         if ($filter_value == 'trending') {
    //             $products_query->where('trending', '1');
    //         }
    //         if ($filter_value == 'title-ascending') {
    //             $products_query->orderBy('name', 'asc');
    //         }
    //         if ($filter_value == 'title-descending') {
    //             $products_query->orderBy('name', 'Desc');
    //         }
    //         if ($filter_value == 'price-ascending') {
    //             $products_query->orderBy('price', 'asc');
    //         }
    //         if ($filter_value == 'price-descending') {
    //             $products_query->orderBy('price', 'Desc');
    //         }
    //         if ($filter_value == 'created-ascending') {
    //             $products_query->orderBy('created_at', 'asc');
    //         }
    //         if ($filter_value == 'created-descending') {
    //             $products_query->orderBy('created_at', 'Desc');
    //         }
    //     }

    //     $products = $products_query->paginate(12);
    //     $data = getThemeSections($currentTheme, $storeSlug, true, true);
    //     $section = (object) $data['section'];
    //     // Get Data from database
    //     $sqlData = getHomePageDatabaseSectionDataFromDatabase($data);
    //     $topNavItems = [];
    //     $menu_id = (array) $section->header->section->menu_type->menu_ids ??
    //     [];
    //     $topNavItems = get_nav_menu($menu_id);

    //     $currency_icon = $currency = Utility::GetValueByName('defult_currancy_symbol', $store->theme_id, $store->id);
    //     if (empty($currency)) {
    //         $currency_icon = $currency = '$';
    //     }

    //     $setting = getAdminAllSetting();
    //     $defaultTimeZone = isset($setting['defult_timezone']) ? $setting['defult_timezone'] : 'Asia/Kolkata';
    //     date_default_timezone_set($defaultTimeZone);
    //     $currentDateTime = date('Y-m-d H:i:s A');
    //     $tax_option = TaxOption::where('store_id', $store->id)
    //         ->where('theme_id', $store->theme_id)
    //         ->pluck('value', 'name')->toArray();

    //     return view('front_end.sections.pages.product_list_filter', compact('tax_option', 'currentTheme', 'slug', 'products', 'currency', 'page', 'currency_icon', 'currentDateTime', 'topNavItems') + $data + $sqlData)->render();
    // }

    // public function product_detail(Request $request, $storeSlug, $product_slug)
    // {
    //     $store = Cache::remember('store_' . $storeSlug, 3600, function () use ($storeSlug) {
    //         return Store::where('slug', $storeSlug)->first();
    //     });
    //     if (!$store) {
    //         abort(404);
    //     }
    //     $store_id = $store->id;
    //     $slug = $store->slug;
    //     $currentTheme = $store->theme_id;
    //     $storeId = $store->id;
    //     $product = Product::where('slug', $product_slug)->where('theme_id', $currentTheme)->where('store_id', $store_id)->first();
    //     if (!$product) {
    //         abort(404);
    //     }
    //     $id = $product->id;
    //     Theme::set($currentTheme);
    //     $languages = Utility::languages();
    //     $data = getThemeSections($currentTheme, $storeSlug, true, true);
    //     $section = (object) $data['section'];
    //     // Get Data from database
    //     $sqlData = getHomePageDatabaseSectionDataFromDatabase($data);
    //     $topNavItems = [];
    //     $menu_id = (array) $section->header->section->menu_type->menu_ids ??
    //     [];
    //     $topNavItems = get_nav_menu($menu_id);

    //     $MainCategoryList = MainCategory::where('status', 1)->where('theme_id', $currentTheme)->where('store_id', $storeId)->get();
    //     $SubCategoryList = SubCategory::where('status', 1)->where('theme_id', $currentTheme)->where('store_id', $storeId)->get();
    //     $has_subcategory = Utility::ThemeSubcategory($currentTheme);
    //     $search_products = Product::where('theme_id', $currentTheme)->where('store_id', $storeId)->get()->pluck('name', 'id');
    //     $ApiController = new ApiController();

    //     $featured_products_data = $ApiController->featured_products($request, $store->slug);
    //     $featured_products = $featured_products_data->getData();

    //     $Stocks = ProductVariant::where('product_id', $id)->first();
    //     if ($Stocks) {
    //         $minPrice = ProductVariant::where('product_id', $id)->min('price');
    //         $maxPrice = ProductVariant::where('product_id', $id)->max('price');

    //         $min_vprice = ProductVariant::where('product_id', $id)->min('variation_price');
    //         $max_vprice = ProductVariant::where('product_id', $id)->max('variation_price');

    //         $mi_price = !empty($minPrice) ? $minPrice : $min_vprice;
    //         $ma_price = !empty($maxPrice) ? $maxPrice : $max_vprice;
    //     } else {
    //         $mi_price = 0;
    //         $ma_price = 0;
    //     }

    //     $currency_icon = $currency = Utility::GetValueByName('defult_currancy_symbol', $store->theme_id, $store->id);
    //     if (empty($currency)) {
    //         $currency_icon = $currency = '$';
    //     }

    //     $per_page = '12';
    //     $destination = 'web';
    //     $bestSeller_fun = Product::bestseller_guest($currentTheme, $storeId, $per_page, $destination);
    //     $bestSeller = [];
    //     if ($bestSeller_fun['status'] == 'success') {
    //         $bestSeller = $bestSeller_fun['bestseller_array'];
    //     }

    //     $product_review = Testimonial::where('product_id', $id)->get();

    //     if (!$product) {
    //         return redirect()->route('page.product-list', $slug)->with('error', __('Product not found.'));
    //     }

    //     $wishlist = Wishlist::where('product_id', $id)->get();
    //     $latest_product = Product::where('theme_id', $currentTheme)->where('store_id', $storeId)->where('product_type', null)->latest()->first();

    //     $MainCategory = MainCategory::where('theme_id', $currentTheme)->where('store_id', $storeId)->get()->pluck('name', 'id');
    //     $MainCategory->prepend('All Products', '0');
    //     $homeproducts = Product::where('theme_id', $currentTheme)->where('store_id', $storeId)->where('product_type', null)->get();
    //     $M_products = Product::whereIn('id', [$id])->first();
    //     $product_stocks = ProductVariant::where('product_id', $id)->where('theme_id', $currentTheme)->limit(3)->get();
    //     $main_pro = Product::where('maincategory_id', $M_products->category_id)->where('theme_id', $currentTheme)->where('store_id', $storeId)->where('product_type', null)->inRandomOrder()->limit(3)->get();

    //     $random_review = Testimonial::where('status', 1)->where('theme_id', $currentTheme)->where('store_id', $storeId)->inRandomOrder()->get();
    //     $reviews = Testimonial::where('status', 1)->where('theme_id', $currentTheme)->where('store_id', $storeId)->get();

    //     $lat_product = Product::orderBy('created_at', 'Desc')->where('theme_id', $currentTheme)->where('store_id', $storeId)->inRandomOrder()->limit(2)->get();

    //     $question = ProductQuestion::where('theme_id', $currentTheme)->where('product_id', $id)->where('store_id', $storeId)->get();

    //     $flashsales = FlashSale::where('theme_id', $currentTheme)->where('store_id', $storeId)->orderBy('created_at', 'Desc')->get();

    //     $setting = getAdminAllSetting();
    //     $defaultTimeZone = isset($setting['defult_timezone']) ? $setting['defult_timezone'] : 'Asia/Kolkata';
    //     date_default_timezone_set($defaultTimeZone);
    //     $currentDateTime = date('Y-m-d H:i:s A');

    //     $country_option = Country::orderBy('name', 'ASC')->pluck('name', 'id')->prepend('Select country', ' ');
    //     $response = Cart::cart_list_cookie($request->all(), $store->id);
    //     $response = json_decode(json_encode($response));
    //     $param = [
    //         'theme_id' => $store->theme_id,
    //         'customer_id' => !empty(\Auth::guard('customers')->user()) ? \Auth::guard('customers')->user()->id : 0,
    //         'slug' => $slug,
    //         'store_id' => $store->id,
    //     ];
    //     $request->merge($param);

    //     $theme = new OfertemagController();
    //     $payment_list_data = $theme->payment_list($request, $slug);
    //     $filtered_payment_list = json_decode(json_encode($payment_list_data));
    //     $payment_list = $payment_list_data;

    //     return view('front_end.sections.pages.product', compact('currentTheme', 'section', 'slug', 'product', 'MainCategoryList', 'SubCategoryList', 'currency', 'currency_icon', 'bestSeller', 'product_review', 'wishlist', 'has_subcategory', 'latest_product', 'search_products', 'featured_products', 'MainCategory', 'homeproducts', 'M_products', 'product_stocks', 'main_pro', 'lat_product', 'random_review', 'reviews', 'question', 'mi_price', 'ma_price', 'flashsales', 'currentDateTime', 'topNavItems', 'country_option', 'response', 'payment_list') + $data + $sqlData);

    // }

    // public function cart_page(Request $request, $slug)
    // {
    //     $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
    //             return Store::where('slug',$slug)->first();
    //         });
    //     if (!$store) {
    //         abort(404);
    //     }
    //     $currentTheme = GetCurrenctTheme($slug);
    //     if ($store) {
    //         $theme_id = $store->theme_id;

    //         $homepage_products = Product::orderBy('created_at', 'Desc')->where('theme_id', $theme_id)->get();

    //         $per_page = '12';
    //         $destination = 'web';
    //         $bestSeller_fun = Product::bestseller_guest($theme_id, $store->id, $store->id, $per_page, $destination);
    //         $bestSeller = [];
    //         if ($bestSeller_fun['status'] == 'success') {
    //             $bestSeller = $bestSeller_fun['bestseller_array'];
    //         }
    //         $data = getThemeSections($currentTheme, $slug, true, true);
    //         $section = (object) $data['section'];
    //         // Get Data from database
    //         $sqlData = getHomePageDatabaseSectionDataFromDatabase($data);
    //         $currantLang = \Cookie::get('LANGUAGE') ?? $store->default_language;
    //         $currency_icon = $currency = Utility::GetValueByName('defult_currancy_symbol', $store->theme_id, $store->id);
    //         if (empty($currency)) {
    //             $currency_icon = $currency = '$';
    //         }

    //         $languages = Utility::languages();
    //         $MainCategory = MainCategory::where('theme_id', $theme_id)->where('store_id', getCurrentStore())->get()->pluck('name', 'id');
    //         $MainCategory->prepend('All Products', '0');
    //         $homeproducts = Product::where('theme_id', $theme_id)->where('store_id', getCurrentStore())->where('product_type', null)->get();
    //         $page_json = arrayToObject(getInnerPageJson($currentTheme, $store->id, 'cart_page'));

    //         return view('front_end.sections.pages.cart', compact('store', 'section', 'currentTheme', 'currency', 'currantLang', 'MainCategory', 'homeproducts', 'languages', 'bestSeller', 'page_json') + $data + $sqlData);
    //     } else {
    //         return redirect()->back()->with('error', __('Permission Denied.'));
    //     }

    // }

    // public function checkout(Request $request, $slug)
    // {
    //     $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
    //             return Store::where('slug',$slug)->first();
    //         });
    //     if (!$store) {
    //         abort(404);
    //     }
    //     $theme_id = $store->theme_id;
    //     $currentTheme = GetCurrenctTheme($slug);
    //     $data = getThemeSections($currentTheme, $slug, true, true);
    //     $section = (object) $data['section'];
    //     // Get Data from database
    //     $sqlData = getHomePageDatabaseSectionDataFromDatabase($data);
    //     $currantLang = \Cookie::get('LANGUAGE') ?? $store->default_language;
    //     $currency = Utility::GetValueByName('defult_currancy_symbol', $store->theme_id, $store->id);
    //     if (empty($currency)) {
    //         $currency = '$';
    //     }

    //     $languages = Utility::languages();

    //     $param = [
    //         'theme_id' => $theme_id,
    //         'customer_id' => !empty(\Auth::guard('customers')->user()) ? \Auth::guard('customers')->user()->id : 0,
    //     ];
    //     $request->merge($param);
    //     $api = new ApiController();

    //     $address_list_data = $api->address_list($request);
    //     $address_list = $address_list_data->getData();

    //     $country_option = Country::orderBy('name', 'ASC')->pluck('name', 'id')->prepend('Select Country', 0);
    //     $settings = Setting::where('theme_id', $theme_id)->where('store_id', $store->id)->pluck('value', 'name')->toArray();
    //     $page_json = arrayToObject(getInnerPageJson($currentTheme, $store->id, 'checkout_page'));

    //     return view('front_end.sections.pages.checkout', compact('store', 'address_list', 'country_option', 'settings', 'currentTheme', 'currency', 'currantLang', 'languages', 'section', 'page_json') + $data + $sqlData);
    // }

    // public function order_track(Request $request, $slug)
    // {
    //     $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
    //             return Store::where('slug',$slug)->first();
    //         });
    //     if (!$store) {
    //         abort(404);
    //     }
    //     $currentTheme = $store->theme_id;
    //     $user = User::where('email', $request->email)->first();
    //     $currency = Utility::GetValueByName('defult_currancy_symbol', $store->theme_id, $store->id);
    //     if (empty($currency)) {
    //         $currency = '$';
    //     }

    //     $currantLang = \Cookie::get('LANGUAGE') ?? $store->default_language;
    //     $languages = Utility::languages();

    //     $pixels = PixelFields::where('store_id', $store->id)
    //         ->where('theme_id', $store->theme_id)
    //         ->get();
    //     $pixelScript = [];
    //     foreach ($pixels as $pixel) {
    //         $pixelScript[] = pixelSourceCode($pixel['platform'], $pixel['pixel_id']);
    //     }

    //     if (!empty($request->order_number) || !empty($request->email)) {

    //         $product_order_id = Order::where('store_id', $store->id)->get();
    //         $order_id = [];
    //         foreach ($product_order_id as $order) {
    //             $order_id[] = $order['product_order_id'];

    //         }
    //         $order_email = OrderBillingDetail::whereIn('product_order_id', $order_id)->pluck('email', 'email')->toArray();
    //         $order_number = Order::where('store_id', $store->id)->pluck('product_order_id', 'product_order_id')->toArray();

    //         if (in_array($request->email, $order_email) && in_array($request->order_number, $order_number)) {
    //             $order_d = OrderBillingDetail::where('email', $request->email)->where('product_order_id', $request->order_number)->first();
    //             $order = Order::where('id', $order_d->order_id)->where('store_id', $store->id)->first();
    //             $order_status = Order::where('product_order_id', $request->order_number)->where('store_id', $store->id)->where('theme_id', $store->theme_id)->first();
    //         } elseif (in_array($request->email, $order_email)) {
    //             $order_d = OrderBillingDetail::where('email', $request->email)->first();
    //             $order = Order::where('id', $order_d->order_id)->where('store_id', $store->id)->first();
    //             $order_status = Order::where('id', $order_d->order_id)->where('store_id', $store->id)->where('theme_id', $store->theme_id)->first();

    //         } elseif (in_array($request->order_number, $order_number)) {
    //             $order = Order::where('product_order_id', $request->order_number)->where('store_id', $store->id)->first();
    //             $order_status = Order::where('product_order_id', $request->order_number)->where('store_id', $store->id)->where('theme_id', $store->theme_id)->first();

    //         } else {
    //             return view('front_end.sections.pages.order_track', compact('currentTheme', 'slug', 'currency', 'currantLang', 'languages', 'store', 'pixelScript'));

    //         }

    //         if (!isset($order)) {
    //             $order_detail = Order::order_detail($order->id ?? null);
    //         } else {
    //             $order_detail = Order::order_detail($order->id);
    //         }
    //         if (!empty($order)) {
    //             $customer = User::where('email', $order->email)->first();
    //         } else {
    //             return redirect()->back()->with('error', __('Order not found.'));
    //         }

    //         return view('front_end.sections.pages.order_track', compact('order', 'order_status', 'order_detail', 'customer', 'slug', 'currentTheme', 'currency', 'currantLang', 'languages', 'store', 'pixelScript'));
    //     } else {
    //         return view('front_end.sections.pages.order_track', compact('currentTheme', 'slug', 'currency', 'currantLang', 'languages', 'store', 'pixelScript'));

    //     }

    // }

    // public function contactUs(Request $request, $slug)
    // {
    //     $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
    //             return Store::where('slug',$slug)->first();
    //         });
    //     if (!$store) {
    //         abort(404);
    //     }
    //     $currentTheme = $store->theme_id;
    //     Theme::set($currentTheme);
    //     $currency = Utility::GetValueByName('defult_currancy_symbol', $store->theme_id, $store->id);
    //     if (empty($currency)) {
    //         $currency = '$';
    //     }

    //     $currantLang = \Cookie::get('LANGUAGE') ?? $store->default_language;
    //     $languages = Utility::languages();
    //     $data = getThemeSections($currentTheme, $slug, true, true);
    //     // Get Data from database
    //     $sqlData = getHomePageDatabaseSectionDataFromDatabase($data);
    //     $section = (object) $data['section'];
    //     $page_json = arrayToObject(getInnerPageJson($currentTheme, $store->id, 'contact_page'));

    //     return view('front_end.sections.pages.contact-us', compact('slug', 'currentTheme', 'currency', 'currantLang', 'languages', 'section', 'store', 'page_json') + $sqlData + $data);
    // }

    // public function search_products(Request $request, $slug)
    // {
    //     $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
    //             return Store::where('slug',$slug)->first();
    //         });
    //     if (!$store) {
    //         $return['html_data'] = null;
    //         $return['message'] = __('Store not found.');

    //         return response()->json($return);
    //     }
    //     $theme_id = $store->theme_id;

    //     $search_pro = $request->product;

    //     $products = Product::where('name', 'LIKE', '%'.$search_pro.'%')->where('store_id', $store->id)->get();
    //     // Check if any matching products were found
    //     if (!$products->isEmpty()) {
    //         // Create an array of product URLs
    //         $productData = [];

    //         // Populate the array with product names and URLs
    //         foreach ($products as $product) {
    //             $url = url($slug.'/product/'.$product->slug);

    //             $productData[] = [
    //                 'name' => $product->name,
    //                 'url' => $url,
    //             ];
    //         }

    //         return response()->json($productData);
    //     } else {
    //         // Handle the case where no matching products were found
    //         return response()->json([]);
    //     }
    // }

    // public function privacy_page(Request $request, $slug)
    // {
    //     $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
    //             return Store::where('slug',$slug)->first();
    //         });
    //     if (empty($store)) {
    //         return redirect()->back();
    //     } else {
    //         $currentTheme = $theme_id = $store->theme_id;
    //     }

    //     $currentTheme = $store->theme_id;
    //     Theme::set($currentTheme);
    //     $currantLang = \Cookie::get('LANGUAGE') ?? $store->default_language;

    //     $data = getThemeSections($currentTheme, $store->slug, true, true);

    //     $section = (object) $data['section'];
    //     // Get Data from database
    //     $sqlData = getHomePageDatabaseSectionDataFromDatabase($data);
    //     $topNavItems = [];
    //     $menu_id = (array) $section->header->section->menu_type->menu_ids ??
    //     [];
    //     $topNavItems = get_nav_menu($menu_id);

    //     $ApiController = new ApiController();
    //     $featured_products_data = $ApiController->featured_products($request, $store->slug);
    //     $featured_products = $featured_products_data->getData();

    //     $pages_data = Page::where('theme_id', $currentTheme)->where('store_id', $store->id)->where('page_name', 'Privacy Policy')->get();

    //     return view('front_end.sections.pages.privacy_policys', compact('slug', 'pages_data', 'featured_products', 'topNavItems') + $data + $sqlData);
    // }

    // public function SoftwareDetails($slug)
    // {
    //     $modules_all = Module::all();
    //     $modules = [];
    //     if (count($modules_all) > 0) {
    //         // Ensure that array_rand() returns an array
    //         $randomKeys = (count($modules_all) === 1)
    //             ? [array_rand($modules_all)]  // Wrap single key in an array
    //             : array_rand($modules_all, (count($modules_all) < 6) ? count($modules_all) : 6);  // Get 6 or fewer random keys

    //         // Proceed with array_intersect_key
    //         $modules = array_intersect_key(
    //             $modules_all, // the array with all keys
    //             array_flip($randomKeys) // flip the random keys array
    //         );
    //     }
    //     $plan = Plan::first();

    //     $addon = AddOnManager::where('name', $slug)->first();

    //     if (!empty($addon) && !empty($addon->module)) {
    //         $module = Module::find($addon->module);
    //         if (!empty($module)) {
    //             try {
    //                 if (module_is_active('LandingPage')) {
    //                     return view('landing-page::marketplace.index', compact('modules', 'module', 'plan'));
    //                 } else {
    //                     return view($module->package_name.'::marketplace.index', compact('modules', 'module', 'plan'));
    //                 }
    //             } catch (\Throwable $th) {

    //             }
    //         }
    //     }

    //     if (module_is_active('LandingPage')) {
    //         $layout = 'landing-page::layouts.marketplace';

    //     } else {
    //         $layout = 'marketplace.marketplace';
    //     }
    //     return view('marketplace.detail_not_found', compact('modules', 'layout'));

    // }

    // public function Software(Request $request)
    // {
    //     // Get the query parameter from the request
    //     $query = $request->query('query');
    //     // Get all modules (assuming Module::getByStatus(1) returns all modules)
    //     $modules = Module::getByStatus(1);

    //     // Filter modules based on the query parameter
    //     if ($query) {
    //         $modules = array_filter($modules, function ($module) use ($query) {
    //             // You may need to adjust this condition based on your requirements
    //             return stripos($module->name, $query) !== false;
    //         });
    //     }
    //     // Rest of your code
    //     if (module_is_active('LandingPage')) {
    //         $layout = 'landing-page::layouts.marketplace';
    //     } else {
    //         $layout = 'marketplace.marketplace';
    //     }

    //     return view('marketplace.software', compact('modules', 'layout'));
    // }

    // public function Pricing()
    // {
    //     $admin_settings = getAdminAllSetting();
    //     if (module_is_active('GoogleCaptcha') && (isset($admin_settings['google_recaptcha_is_on']) ? $admin_settings['google_recaptcha_is_on'] : 'off') == 'on') {
    //         config(['captcha.secret' => isset($admin_settings['google_recaptcha_secret']) ? $admin_settings['google_recaptcha_secret'] : '']);
    //         config(['captcha.sitekey' => isset($admin_settings['google_recaptcha_key']) ? $admin_settings['google_recaptcha_key'] : '']);
    //     }
    //     if (auth()->check()) {
    //         if (auth()->user()->type == 'admin') {
    //             return redirect('plans');
    //         } else {
    //             return redirect('dashboard');
    //         }
    //     } else {
    //         $plan = Plan::first();
    //         $modules = Module::getByStatus(1);

    //         if (module_is_active('LandingPage')) {
    //             $layout = 'landing-page::layouts.marketplace';

    //             return view('landing-page::layouts.pricing', compact('modules', 'plan', 'layout'));

    //         } else {
    //             $layout = 'marketplace.marketplace';
    //         }

    //         return view('marketplace.pricing', compact('modules', 'plan', 'layout'));
    //     }
    // }

    // public function top_brand_category_chart(Request $request)
    // {
    //     $tab_name = $request->tabId;
    //     $type = $request->type;
    //     if ($type == 'category') {
    //         if ($tab_name == '#all-category-order') {
    //             $top_sales = MainCategory::select('main_categories.name as sale_name', 'main_categories.image_path as sale_image_path', \DB::raw('SUM(orders.final_price) as total_sale'))
    //                 ->join('products', 'main_categories.id', '=', 'products.maincategory_id')
    //                 ->join('orders', function ($join) {
    //                     $join->on('products.id', '=', \DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(orders.product_id, ',', numbers.n), ',', -1)"))
    //                         ->crossJoin(\DB::raw('(SELECT 1 + a.N + b.N * 10 AS n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a CROSS JOIN (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b) AS numbers'));
    //                 })
    //                 ->where('main_categories.theme_id', APP_THEME())
    //                 ->where('main_categories.store_id', getCurrentStore())
    //                 ->groupBy('main_categories.name')
    //                 ->orderBy('total_sale', 'desc')
    //                 ->get();

    //         } elseif ($tab_name == '#today-category-order') {

    //             $top_sales = MainCategory::select('main_categories.name as sale_name', 'main_categories.image_path as sale_image_path', \DB::raw('SUM(orders.final_price) as total_sale'))
    //                 ->join('products', 'main_categories.id', '=', 'products.maincategory_id')
    //                 ->join('orders', function ($join) {
    //                     $join->on('products.id', '=', \DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(orders.product_id, ',', numbers.n), ',', -1)"))
    //                         ->crossJoin(\DB::raw('(SELECT 1 + a.N + b.N * 10 AS n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a CROSS JOIN (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b) AS numbers'))
    //                         ->whereDate('orders.created_at', '=', \DB::raw('CURDATE()'));
    //                 })
    //                 ->where('main_categories.theme_id', APP_THEME())
    //                 ->where('main_categories.store_id', getCurrentStore())
    //                 ->groupBy('main_categories.name')
    //                 ->orderBy('total_sale', 'desc')
    //                 ->get();

    //         } elseif ($tab_name == '#week-category-order') {
    //             $top_sales = MainCategory::select('main_categories.name as sale_name', 'main_categories.image_path as sale_image_path', \DB::raw('SUM(orders.final_price) as total_sale'))
    //                 ->join('products', 'main_categories.id', '=', 'products.maincategory_id')
    //                 ->join('orders', function ($join) {
    //                     $join->on('products.id', '=', \DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(orders.product_id, ',', numbers.n), ',', -1)"))
    //                         ->crossJoin(\DB::raw('(SELECT 1 + a.N + b.N * 10 AS n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a CROSS JOIN (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b) AS numbers'))
    //                         ->whereBetween('orders.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    //                 })
    //                 ->where('main_categories.theme_id', APP_THEME())
    //                 ->where('main_categories.store_id', getCurrentStore())
    //                 ->groupBy('main_categories.name')
    //                 ->orderBy('total_sale', 'desc')
    //                 ->get();

    //         } elseif ($tab_name == '#month-category-order') {
    //             $top_sales = MainCategory::select('main_categories.name as sale_name', 'main_categories.image_path as sale_image_path', \DB::raw('SUM(orders.final_price) as total_sale'))
    //                 ->join('products', 'main_categories.id', '=', 'products.maincategory_id')
    //                 ->join('orders', function ($join) {
    //                     $join->on('products.id', '=', \DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(orders.product_id, ',', numbers.n), ',', -1)"))
    //                         ->crossJoin(\DB::raw('(SELECT 1 + a.N + b.N * 10 AS n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a CROSS JOIN (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b) AS numbers'))
    //                         ->whereYear('orders.created_at', now()->year)
    //                         ->whereMonth('orders.created_at', now()->month);
    //                 })
    //                 ->where('main_categories.theme_id', APP_THEME())
    //                 ->where('main_categories.store_id', getCurrentStore())
    //                 ->groupBy('main_categories.name')
    //                 ->orderBy('total_sale', 'desc')
    //                 ->get();
    //         } elseif ($tab_name == '#year-category-order') {
    //             $top_sales = MainCategory::select('main_categories.name as sale_name', 'main_categories.image_path as sale_image_path', \DB::raw('SUM(orders.final_price) as total_sale'))
    //                 ->join('products', 'main_categories.id', '=', 'products.maincategory_id')
    //                 ->join('orders', function ($join) {
    //                     $join->on('products.id', '=', \DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(orders.product_id, ',', numbers.n), ',', -1)"))
    //                         ->crossJoin(\DB::raw('(SELECT 1 + a.N + b.N * 10 AS n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a CROSS JOIN (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b) AS numbers'))
    //                         ->whereYear('orders.created_at', now()->year);
    //                 })
    //                 ->where('main_categories.theme_id', APP_THEME())
    //                 ->where('main_categories.store_id', getCurrentStore())
    //                 ->groupBy('main_categories.name')
    //                 ->orderBy('total_sale', 'desc')
    //                 ->get();
    //         } else {
    //             $top_sales = MainCategory::select('main_categories.name as sale_name', 'main_categories.image_path as sale_image_path', \DB::raw('SUM(orders.final_price) as total_sale'))
    //                 ->join('products', 'main_categories.id', '=', 'products.maincategory_id')
    //                 ->join('orders', function ($join) {
    //                     $join->on('products.id', '=', \DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(orders.product_id, ',', numbers.n), ',', -1)"))
    //                         ->crossJoin(\DB::raw('(SELECT 1 + a.N + b.N * 10 AS n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a CROSS JOIN (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b) AS numbers'));
    //                 })
    //                 ->where('main_categories.theme_id', APP_THEME())
    //                 ->where('main_categories.store_id', getCurrentStore())
    //                 ->groupBy('main_categories.name')
    //                 ->orderBy('total_sale', 'desc')
    //                 ->get();
    //         }
    //     } else {
    //         if ($tab_name == '#all-brand-order') {
    //             $top_sales = ProductBrand::select('product_brands.name as sale_name', 'product_brands.logo as sale_image_path', \DB::raw('SUM(orders.final_price) as total_sale'))
    //                 ->join('products', 'product_brands.id', '=', 'products.brand_id')
    //                 ->join('orders', function ($join) {
    //                     $join->on('products.id', '=', \DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(orders.product_id, ',', numbers.n), ',', -1)"))
    //                         ->crossJoin(\DB::raw('(SELECT 1 + a.N + b.N * 10 AS n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a CROSS JOIN (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b) AS numbers'));
    //                 })
    //                 ->where('product_brands.theme_id', APP_THEME())
    //                 ->where('product_brands.store_id', getCurrentStore())
    //                 ->groupBy('product_brands.name')
    //                 ->orderBy('total_sale', 'desc')
    //                 ->get();
    //         } elseif ($tab_name == '#today-brand-order') {

    //             $top_sales = ProductBrand::select('product_brands.name as sale_name', \DB::raw('SUM(orders.final_price) as total_sale'))
    //                 ->join('products', 'product_brands.id', '=', 'products.brand_id')
    //                 ->join('orders', function ($join) {
    //                     $join->on('products.id', '=', \DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(orders.product_id, ',', numbers.n), ',', -1)"))
    //                         ->crossJoin(\DB::raw('(SELECT 1 + a.N + b.N * 10 AS n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a CROSS JOIN (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b) AS numbers'))
    //                         ->whereDate('orders.created_at', '=', \DB::raw('CURDATE()'));
    //                 })
    //                 ->where('product_brands.theme_id', APP_THEME())
    //                 ->where('product_brands.store_id', getCurrentStore())
    //                 ->groupBy('product_brands.name')
    //                 ->orderBy('total_sale', 'desc')
    //                 ->get();

    //         } elseif ($tab_name == '#week-brand-order') {
    //             $top_sales = ProductBrand::select('product_brands.name as sale_name', 'product_brands.logo as sale_image_path', \DB::raw('SUM(orders.final_price) as total_sale'))
    //                 ->join('products', 'product_brands.id', '=', 'products.brand_id')
    //                 ->join('orders', function ($join) {
    //                     $join->on('products.id', '=', \DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(orders.product_id, ',', numbers.n), ',', -1)"))
    //                         ->crossJoin(\DB::raw('(SELECT 1 + a.N + b.N * 10 AS n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a CROSS JOIN (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b) AS numbers'))
    //                         ->whereBetween('orders.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    //                 })
    //                 ->where('product_brands.theme_id', APP_THEME())
    //                 ->where('product_brands.store_id', getCurrentStore())
    //                 ->groupBy('product_brands.name')
    //                 ->orderBy('total_sale', 'desc')
    //                 ->get();
    //         } elseif ($tab_name == '#month-brand-order') {
    //             $top_sales = ProductBrand::select('product_brands.name as sale_name', 'product_brands.logo as sale_image_path', \DB::raw('SUM(orders.final_price) as total_sale'))
    //                 ->join('products', 'product_brands.id', '=', 'products.brand_id')
    //                 ->join('orders', function ($join) {
    //                     $join->on('products.id', '=', \DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(orders.product_id, ',', numbers.n), ',', -1)"))
    //                         ->crossJoin(\DB::raw('(SELECT 1 + a.N + b.N * 10 AS n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a CROSS JOIN (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b) AS numbers'))
    //                         ->whereYear('orders.created_at', now()->year)
    //                         ->whereMonth('orders.created_at', now()->month);
    //                 })
    //                 ->where('product_brands.theme_id', APP_THEME())
    //                 ->where('product_brands.store_id', getCurrentStore())
    //                 ->groupBy('product_brands.name')
    //                 ->orderBy('total_sale', 'desc')
    //                 ->get();
    //         } elseif ($tab_name == '#year-brand-order') {
    //             $top_sales = ProductBrand::select('product_brands.name as sale_name', 'product_brands.logo as sale_image_path', \DB::raw('SUM(orders.final_price) as total_sale'))
    //                 ->join('products', 'product_brands.id', '=', 'products.brand_id')
    //                 ->join('orders', function ($join) {
    //                     $join->on('products.id', '=', \DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(orders.product_id, ',', numbers.n), ',', -1)"))
    //                         ->crossJoin(\DB::raw('(SELECT 1 + a.N + b.N * 10 AS n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a CROSS JOIN (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b) AS numbers'))
    //                         ->whereYear('orders.created_at', now()->year);
    //                 })
    //                 ->where('product_brands.theme_id', APP_THEME())
    //                 ->where('product_brands.store_id', getCurrentStore())
    //                 ->groupBy('product_brands.name')
    //                 ->orderBy('total_sale', 'desc')
    //                 ->get();
    //         } else {
    //             $top_sales = ProductBrand::select('product_brands.name as sale_name', 'product_brands.logo as sale_image_path', \DB::raw('SUM(orders.final_price) as total_sale'))
    //                 ->join('products', 'product_brands.id', '=', 'products.brand_id')
    //                 ->join('orders', function ($join) {
    //                     $join->on('products.id', '=', \DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(orders.product_id, ',', numbers.n), ',', -1)"))
    //                         ->crossJoin(\DB::raw('(SELECT 1 + a.N + b.N * 10 AS n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a CROSS JOIN (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b) AS numbers'));
    //                 })
    //                 ->where('product_brands.theme_id', APP_THEME())
    //                 ->where('product_brands.store_id', getCurrentStore())
    //                 ->groupBy('product_brands.name')
    //                 ->orderBy('total_sale', 'desc')
    //                 ->get();
    //         }
    //     }
    //     $html = '';
    //     $html = view('order.brand_category_chart', compact('tab_name', 'top_sales'))->render();

    //     $return['html'] = $html;
    //     $return['tab_name'] = $tab_name;
    //     $return['type'] = $type;

    //     return response()->json($return);
    // }

    // public function best_selling_brand_chart(Request $request)
    // {
    //     $store_id = Store::where('id', getCurrentStore())->first();
    //     //$currency = Utility::GetValueByName('CURRENCY');
    //     $currency = Utility::GetValueByName('defult_currancy_symbol', $store->theme_id, $store->id);
    //     if (empty($currency)) {
    //         //$currency = Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store_id);
    //         $currency = '$';
    //     }
    //     if ($request->chart_data == 'last-month') {
    //         $data = 'last-month';
    //         $lastMonth = Carbon::now()->subMonth();
    //         $prevMonth = strtotime('-1 month');
    //         $start = strtotime(date('Y-m-01', $prevMonth));
    //         $end = strtotime(date('Y-m-t', $prevMonth));

    //         $customer = Order::where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore())->whereYear('order_date', date('Y'))->get()->count();
    //         $customer_total = Customer::where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore())->where('regiester_date', '!=', null)->whereYear('regiester_date', date('Y'))->get()->count();
    //         $totaluser = 0;
    //         $guest = '';

    //         $lastDayofMonth = Carbon::now()->subMonthNoOverflow()->endOfMonth();
    //         $lastday = date('j', strtotime($lastDayofMonth));

    //         $orders = Order::selectRaw('orders.*,DATE(order_date) as DATE,MONTH(order_date) as month');
    //         $orders->where('order_date', '>=', date('Y-m-01', $start))->where('order_date', '<=', date('Y-m-t', $end))->where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore());
    //         $orders = $orders->get();
    //         $TotalOrder = $orders->count();

    //         $totalDuePurchaseorder = 0;
    //         $grossSaleTotalArray = [];
    //         $netSaleTotalArray = [];
    //         $CouponTotalArray = [];
    //         $ShippingTotalArray = [];
    //         $OrderTotalArray = [];
    //         $totalduepurchaseorderArray = [];
    //         $averageGrossSales = [];
    //         $PurchasedItemArray = [];
    //         $totalProductQuantity = 0;
    //         $PurchasedProductItemTotal = 0;
    //         $TotalgrossSale = 0;
    //         $TotalNetSale = 0;
    //         $TotalShippingCharge = 0;
    //         $TotalCouponAmount = 0;
    //         foreach ($orders as $order) {
    //             $day = (int) date('j', strtotime($order->DATE)); // Extract day of the month

    //             $netSaleTotalArray[$day][] = (float) ($order->final_price - $order->delivery_price - $order->tax_price);
    //             $grossSaleTotalArray[$day][] = (float) $order->final_price;
    //             $CouponTotalArray[$day][] = (float) $order['coupon_price'];
    //             $ShippingTotalArray[$day][] = (float) $order->delivery_price;
    //             $OrderTotalArray[$day][] = 1;
    //             $products = json_decode($order['product_json'], true);
    //             foreach ($products as $product) {
    //                 $totalProductQuantity = intval($product['qty']);
    //                 $PurchasedItemArray[$day][] = $totalProductQuantity;
    //                 $PurchasedProductItemTotal += $totalProductQuantity;
    //             }
    //             $TotalgrossSale += (float) $order->final_price;
    //             $TotalNetSale += (float) ($order->final_price - $order->delivery_price - $order->tax_price);
    //             $TotalCouponAmount += (float) $order['coupon_price'];
    //             $TotalShippingCharge += (float) $order->delivery_price;
    //         }

    //         for ($i = 1; $i <= $lastday; $i++) {
    //             $GrossSaleTotal[] = array_key_exists($i, $grossSaleTotalArray) ? array_sum($grossSaleTotalArray[$i]) : 0;
    //             $NetSaleTotal[] = array_key_exists($i, $netSaleTotalArray) ? array_sum($netSaleTotalArray[$i]) : 0;
    //             $ShippingTotal[] = array_key_exists($i, $ShippingTotalArray) ? array_sum($ShippingTotalArray[$i]) : 0;
    //             $CouponTotal[] = array_key_exists($i, $CouponTotalArray) ? array_sum($CouponTotalArray[$i]) : 0;
    //             $TotalOrderCount[] = array_key_exists($i, $OrderTotalArray) ? count($OrderTotalArray[$i]) : 0;

    //             $PurchasedItemTotal[] = array_key_exists($i, $PurchasedItemArray) ? array_sum($PurchasedItemArray[$i]) : 0;

    //             $dailySales = array_key_exists($i, $grossSaleTotalArray) ? $grossSaleTotalArray[$i] : [];
    //             $averageGrossSales[] = count($dailySales) > 0 ? (array_sum($dailySales) / count($dailySales)) : 0;

    //             $dailyNetSales = array_key_exists($i, $netSaleTotalArray) ? $netSaleTotalArray[$i] : [];
    //             $averageNetSales[] = count($dailyNetSales) > 0 ? (array_sum($dailyNetSales) / count($dailyNetSales)) : 0;
    //         }

    //         $monthList = $month = $this->getLastMonthDatesFormatted();
    //     } elseif ($request->chart_data == 'this-month') {
    //         $start = strtotime(date('Y-m-01'));
    //         $end = strtotime(date('Y-m-t'));
    //         $day = (int) date('j', strtotime($end));

    //         $orders = Order::selectRaw('orders.*,DATE(order_date) as DATE,MONTH(order_date) as month');
    //         $orders->where('order_date', '>=', date('Y-m-01', $start))->where('order_date', '<=', date('Y-m-t', $end))->where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore());
    //         $orders = $orders->get();
    //         $TotalOrder = $orders->count();

    //         $totalDuePurchaseorder = 0;
    //         $grossSaleTotalArray = [];
    //         $netSaleTotalArray = [];
    //         $CouponTotalArray = [];
    //         $ShippingTotalArray = [];
    //         $OrderTotalArray = [];
    //         $totalduepurchaseorderArray = [];
    //         $averageGrossSales = [];
    //         $PurchasedItemArray = [];
    //         $totalProductQuantity = 0;
    //         $PurchasedProductItemTotal = 0;
    //         $TotalgrossSale = 0;
    //         $TotalNetSale = 0;
    //         $TotalShippingCharge = 0;
    //         $TotalCouponAmount = 0;

    //         foreach ($orders as $order) {
    //             $day = (int) date('j', strtotime($order->DATE));
    //             $userTotalArray[$day][] = $order->order_date;

    //             $netSaleTotalArray[$day][] = (float) ($order->final_price - $order->delivery_price - $order->tax_price);
    //             $grossSaleTotalArray[$day][] = (float) $order->final_price;
    //             $CouponTotalArray[$day][] = (float) $order['coupon_price'];
    //             $ShippingTotalArray[$day][] = (float) $order->delivery_price;
    //             $OrderTotalArray[$day][] = 1;
    //             $products = json_decode($order['product_json'], true);
    //             foreach ($products as $product) {
    //                 $totalProductQuantity = intval($product['qty']);
    //                 $PurchasedItemArray[$day][] = $totalProductQuantity;
    //                 $PurchasedProductItemTotal += $totalProductQuantity;
    //             }
    //             $TotalgrossSale += (float) $order->final_price;
    //             $TotalNetSale += (float) ($order->final_price - $order->delivery_price - $order->tax_price);
    //             $TotalCouponAmount += (float) $order['coupon_price'];
    //             $TotalShippingCharge += (float) $order->delivery_price;
    //         }
    //         $lastDayofMonth = \Carbon\Carbon::now()->endOfMonth()->toDateString();
    //         $lastday = date('j', strtotime($lastDayofMonth));

    //         for ($i = 1; $i <= $lastday; $i++) {
    //             $GrossSaleTotal[] = array_key_exists($i, $grossSaleTotalArray) ? array_sum($grossSaleTotalArray[$i]) : 0;
    //             $NetSaleTotal[] = array_key_exists($i, $netSaleTotalArray) ? array_sum($netSaleTotalArray[$i]) : 0;
    //             $ShippingTotal[] = array_key_exists($i, $ShippingTotalArray) ? array_sum($ShippingTotalArray[$i]) : 0;
    //             $CouponTotal[] = array_key_exists($i, $CouponTotalArray) ? array_sum($CouponTotalArray[$i]) : 0;
    //             $TotalOrderCount[] = array_key_exists($i, $OrderTotalArray) ? count($OrderTotalArray[$i]) : 0;

    //             $PurchasedItemTotal[] = array_key_exists($i, $PurchasedItemArray) ? array_sum($PurchasedItemArray[$i]) : 0;

    //             $dailySales = array_key_exists($i, $grossSaleTotalArray) ? $grossSaleTotalArray[$i] : [];
    //             $averageGrossSales[] = count($dailySales) > 0 ? (array_sum($dailySales) / count($dailySales)) : 0;

    //             $dailyNetSales = array_key_exists($i, $netSaleTotalArray) ? $netSaleTotalArray[$i] : [];
    //             $averageNetSales[] = count($dailyNetSales) > 0 ? (array_sum($dailyNetSales) / count($dailyNetSales)) : 0;
    //         }
    //         $monthList = $month = $this->getCurrentMonthDates();
    //     } elseif ($request->chart_data == 'seven-day') {
    //         $startDate = now()->subDays(6);

    //         $TotalOrder = 0;
    //         $totalDuePurchaseorder = 0;
    //         $grossSaleTotalArray = [];
    //         $netSaleTotalArray = [];
    //         $CouponTotalArray = [];
    //         $ShippingTotalArray = [];
    //         $OrderTotalArray = [];
    //         $totalduepurchaseorderArray = [];
    //         $averageGrossSales = [];
    //         $PurchasedItemArray = [];
    //         $totalProductQuantity = 0;
    //         $PurchasedProductItemTotal = 0;
    //         $TotalgrossSale = 0;
    //         $TotalNetSale = 0;
    //         $TotalShippingCharge = 0;
    //         $TotalCouponAmount = 0;
    //         $monthList = [];
    //         $previous_week = strtotime('-1 week +1 day');

    //         for ($i = 0; $i <= 7 - 1; $i++) {
    //             $date = date('Y-m-d', $previous_week);
    //             $previous_week = strtotime(date('Y-m-d', $previous_week).' +1 day');
    //             $monthList[] = __(date('d-M', strtotime($date)));

    //             $ordersForDate = Order::whereDate('order_date', $date)
    //                 ->where('theme_id', $store_id->theme_id)
    //                 ->where('store_id', getCurrentStore())
    //                 ->get();
    //             $TotalOrder += $ordersForDate->count();
    //             $totalPurchasedItemsForDate = 0;

    //             foreach ($ordersForDate as $order) {
    //                 $products = json_decode($order->product_json, true);

    //                 $totalProductQuantity = array_reduce($products, function ($carry, $product) {
    //                     return $carry + intval($product['qty']);
    //                 }, 0);
    //                 $totalPurchasedItemsForDate += $totalProductQuantity;
    //                 $PurchasedProductItemTotal += $totalProductQuantity;
    //             }
    //             $PurchasedItemTotal[] = $totalPurchasedItemsForDate;

    //             $totalOrdersForDate = Order::whereDate('order_date', $date)
    //                 ->where('theme_id', $store_id->theme_id)
    //                 ->where('store_id', getCurrentStore())
    //                 ->count();

    //             $GrossSaleTotal[] = Order::whereDate('order_date', $date)->where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore())->get()->sum('final_price');

    //             $NetSaleTotal[] = Order::whereDate('order_date', $date)
    //                 ->where('theme_id', $store_id->theme_id)
    //                 ->where('store_id', getCurrentStore())
    //                 ->get()
    //                 ->sum(function ($order) {
    //                     return $order->final_price - $order->delivery_price - $order->tax_price;
    //                 });
    //             $CouponTotal[] = Order::whereDate('order_date', $date)->where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore())->get()->sum('coupon_price');
    //             $ShippingTotal[] = Order::whereDate('order_date', $date)->where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore())->get()->sum('delivery_price');
    //             $TotalOrderCount[] = $totalOrdersForDate;

    //             $averageGrossSales[] = $totalOrdersForDate > 0 ? ($GrossSaleTotal[count($GrossSaleTotal) - 1] / $totalOrdersForDate) : 0;
    //             $averageNetSales[] = $totalOrdersForDate > 0 ? ($NetSaleTotal[count($NetSaleTotal) - 1] / $totalOrdersForDate) : 0;

    //             $TotalgrossSale += Order::whereDate('order_date', $date)->where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore())->get()->sum('final_price');
    //             $TotalNetSale += Order::whereDate('order_date', $date)
    //                 ->where('theme_id', $store_id->theme_id)
    //                 ->where('store_id', getCurrentStore())
    //                 ->get()
    //                 ->sum(function ($order) {
    //                     return $order->final_price - $order->delivery_price - $order->tax_price;
    //                 });
    //             $TotalCouponAmount += Order::whereDate('order_date', $date)->where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore())->get()->sum('coupon_price');
    //             $TotalShippingCharge += Order::whereDate('order_date', $date)->where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore())->get()->sum('delivery_price');
    //             $TotalOrderCount[] = $totalOrdersForDate;
    //         }
    //     } elseif ($request->chart_data == 'year') {

    //         $TotalOrder = Order::where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore())->whereYear('order_date', date('Y'))->get()->count();

    //         $orders = Order::selectRaw('orders.*,MONTH(order_date) as month,YEAR(order_date) as year');
    //         $start = strtotime(date('Y-01'));
    //         $end = strtotime(date('Y-12'));
    //         $orders->where('order_date', '>=', date('Y-m-01', $start))->where('order_date', '<=', date('Y-m-t', $end))->where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore());
    //         $orders = $orders->get();
    //         $order = Order::where('theme_id', $store_id->theme_id)
    //             ->where('store_id', getCurrentStore())
    //             ->whereYear('order_date', date('Y'))
    //             ->get()->count();

    //         $totalDuePurchaseorder = 0;
    //         $grossSaleTotalArray = [];
    //         $netSaleTotalArray = [];
    //         $CouponTotalArray = [];
    //         $ShippingTotalArray = [];
    //         $OrderTotalArray = [];
    //         $totalduepurchaseorderArray = [];
    //         $averageGrossSales = [];
    //         $PurchasedItemArray = [];
    //         $totalProductQuantity = 0;
    //         $PurchasedProductItemTotal = 0;
    //         $TotalgrossSale = 0;
    //         $TotalNetSale = 0;
    //         $TotalShippingCharge = 0;
    //         $TotalCouponAmount = 0;
    //         foreach ($orders as $order) {
    //             $netSaleTotalArray[$order->month][] = (float) ($order->final_price - $order->delivery_price - $order->tax_price);
    //             $grossSaleTotalArray[$order->month][] = (float) $order->final_price;
    //             $CouponTotalArray[$order->month][] = (float) $order['coupon_price'];
    //             $ShippingTotalArray[$order->month][] = (float) $order->delivery_price;
    //             $OrderTotalArray[$order->month][] = 1;
    //             $products = json_decode($order['product_json'], true);
    //             foreach ($products as $product) {
    //                 $totalProductQuantity = intval($product['qty']);
    //                 $PurchasedItemArray[$order->month][] = $totalProductQuantity;
    //                 $PurchasedProductItemTotal += $totalProductQuantity;
    //             }
    //             $TotalgrossSale += (float) $order->final_price;
    //             $TotalNetSale += (float) ($order->final_price - $order->delivery_price - $order->tax_price);
    //             $TotalCouponAmount += (float) $order['coupon_price'];
    //             $TotalShippingCharge += (float) $order->delivery_price;
    //         }
    //         for ($i = 1; $i <= 12; $i++) {

    //             $GrossSaleTotal[] = array_key_exists($i, $grossSaleTotalArray) ? array_sum($grossSaleTotalArray[$i]) : 0;
    //             $NetSaleTotal[] = array_key_exists($i, $netSaleTotalArray) ? array_sum($netSaleTotalArray[$i]) : 0;
    //             $ShippingTotal[] = array_key_exists($i, $ShippingTotalArray) ? array_sum($ShippingTotalArray[$i]) : 0;
    //             $CouponTotal[] = array_key_exists($i, $CouponTotalArray) ? array_sum($CouponTotalArray[$i]) : 0;
    //             $TotalOrderCount[] = array_key_exists($i, $OrderTotalArray) ? count($OrderTotalArray[$i]) : 0;

    //             $PurchasedItemTotal[] = array_key_exists($i, $PurchasedItemArray) ? array_sum($PurchasedItemArray[$i]) : 0;

    //             $monthlySales = array_key_exists($i, $grossSaleTotalArray) ? $grossSaleTotalArray[$i] : [];
    //             $average = count($monthlySales) > 0 ? (array_sum($monthlySales) / count($monthlySales)) : 0;
    //             $averageGrossSales[] = $average;

    //             $monthlySales = array_key_exists($i, $netSaleTotalArray) ? $netSaleTotalArray[$i] : [];
    //             $netsaleaverage = count($monthlySales) > 0 ? (array_sum($monthlySales) / count($monthlySales)) : 0;
    //             $averageNetSales[] = $netsaleaverage;
    //         }
    //         $monthList = $month = $this->yearMonth();
    //     } else {
    //         if (str_contains($request->Date, ' to ')) {
    //             $date_range = explode(' to ', $request->Date);
    //             if (count($date_range) === 2) {
    //                 $form_date = date('Y-m-d', strtotime($date_range[0]));
    //                 $to_date = date('Y-m-d', strtotime($date_range[1]));
    //             } else {
    //                 $start_date = date('Y-m-d', strtotime($date_range[0]));
    //                 $end_date = date('Y-m-d', strtotime($date_range[0]));
    //             }
    //         } else {

    //             $form_date = date('Y-m-d', strtotime($request->Date));
    //             $to_date = date('Y-m-d', strtotime($request->Date));
    //         }
    //         $orders = Order::selectRaw('orders.*,DATE(order_date) as DATE,MONTH(order_date) as month');
    //         $orders->whereDate('order_date', '>=', $form_date)->whereDate('order_date', '<=', $to_date)->where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore());
    //         $orders = $orders->get();
    //         $TotalOrder = $orders->count();

    //         $totalDuePurchaseorder = 0;
    //         $grossSaleTotalArray = [];
    //         $netSaleTotalArray = [];
    //         $CouponTotalArray = [];
    //         $ShippingTotalArray = [];
    //         $OrderTotalArray = [];
    //         $totalduepurchaseorderArray = [];
    //         $averageGrossSales = [];
    //         $PurchasedItemArray = [];
    //         $totalProductQuantity = 0;
    //         $PurchasedProductItemTotal = 0;
    //         $TotalgrossSale = 0;
    //         $TotalNetSale = 0;
    //         $TotalShippingCharge = 0;
    //         $TotalCouponAmount = 0;

    //         $monthLists = Order::selectRaw('orders.*,DATE(order_date) as DATE,MONTH(order_date) as month');
    //         $monthLists = Order::whereDate('order_date', '>=', $form_date)
    //             ->whereDate('order_date', '<=', $to_date)->where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore());
    //         $monthLists = $monthLists->get();

    //         foreach ($monthLists as $monthLists_date) {
    //             $data[] = date('y-n-j', strtotime($monthLists_date->order_date));
    //             $data_month[] = date('Y-m-d', strtotime($monthLists_date->order_date));
    //         }
    //         if (!empty($data) && is_array($data)) {
    //             $List = array_values(array_unique($data));
    //             $monthList_data = $List;
    //             $List_month = array_values(array_unique($data_month));
    //             $monthList = $List_month;
    //         } else {
    //             $List = [];
    //             $monthList_data = [];
    //             $data_month[] = date('y-n-j');
    //             $List_month = array_values(array_unique($data_month));
    //             $monthList = $List_month;
    //         }

    //         foreach ($orders as $order) {
    //             $day = date('y-n-j', strtotime($order->DATE));
    //             $userTotalArray[$day][] = date('y-n-j', strtotime($order->order_date));

    //             $netSaleTotalArray[$day][] = (float) ($order->final_price - $order->delivery_price - $order->tax_price);
    //             $grossSaleTotalArray[$day][] = (float) $order->final_price;
    //             $CouponTotalArray[$day][] = (float) $order['coupon_price'];
    //             $ShippingTotalArray[$day][] = (float) $order->delivery_price;
    //             $OrderTotalArray[$day][] = 1;
    //             $products = json_decode($order['product_json'], true);
    //             foreach ($products as $product) {
    //                 $totalProductQuantity = intval($product['qty']);
    //                 $PurchasedItemArray[$day][] = $totalProductQuantity;
    //                 $PurchasedProductItemTotal += $totalProductQuantity;
    //             }
    //             $TotalgrossSale += (float) $order->final_price;
    //             $TotalNetSale += (float) ($order->final_price - $order->delivery_price - $order->tax_price);
    //             $TotalCouponAmount += (float) $order['coupon_price'];
    //             $TotalShippingCharge += (float) $order->delivery_price;
    //         }

    //         if (!empty($data) && is_array($data)) {
    //             foreach ($monthList_data as $month) {
    //                 $GrossSaleTotal[] = array_key_exists($month, $grossSaleTotalArray) ? array_sum($grossSaleTotalArray[$month]) : 0;
    //                 $NetSaleTotal[] = array_key_exists($month, $netSaleTotalArray) ? array_sum($netSaleTotalArray[$month]) : 0;
    //                 $ShippingTotal[] = array_key_exists($month, $ShippingTotalArray) ? array_sum($ShippingTotalArray[$month]) : 0;
    //                 $CouponTotal[] = array_key_exists($month, $CouponTotalArray) ? array_sum($CouponTotalArray[$month]) : 0;
    //                 $TotalOrderCount[] = array_key_exists($month, $OrderTotalArray) ? count($OrderTotalArray[$month]) : 0;

    //                 $PurchasedItemTotal[] = array_key_exists($month, $PurchasedItemArray) ? array_sum($PurchasedItemArray[$month]) : 0;

    //                 $dailySales = array_key_exists($month, $grossSaleTotalArray) ? $grossSaleTotalArray[$month] : [];
    //                 $averageGrossSales[] = count($dailySales) > 0 ? (array_sum($dailySales) / count($dailySales)) : 0;

    //                 $dailyNetSales = array_key_exists($month, $netSaleTotalArray) ? $netSaleTotalArray[$month] : [];
    //                 $averageNetSales[] = count($dailyNetSales) > 0 ? (array_sum($dailyNetSales) / count($dailyNetSales)) : 0;
    //             }
    //         } else {
    //             $month = date('y-n-j');
    //             $GrossSaleTotal[] = array_key_exists($month, $grossSaleTotalArray) ? array_sum($grossSaleTotalArray[$month]) : 0;
    //             $NetSaleTotal[] = array_key_exists($month, $netSaleTotalArray) ? array_sum($netSaleTotalArray[$month]) : 0;
    //             $ShippingTotal[] = array_key_exists($month, $ShippingTotalArray) ? array_sum($ShippingTotalArray[$month]) : 0;
    //             $CouponTotal[] = array_key_exists($month, $CouponTotalArray) ? array_sum($CouponTotalArray[$month]) : 0;
    //             $TotalOrderCount[] = array_key_exists($month, $OrderTotalArray) ? count($OrderTotalArray[$month]) : 0;

    //             $PurchasedItemTotal[] = array_key_exists($month, $PurchasedItemArray) ? array_sum($PurchasedItemArray[$month]) : 0;

    //             $dailySales = array_key_exists($month, $grossSaleTotalArray) ? $grossSaleTotalArray[$month] : [];
    //             $averageGrossSales[] = count($dailySales) > 0 ? (array_sum($dailySales) / count($dailySales)) : 0;

    //             $dailyNetSales = array_key_exists($month, $netSaleTotalArray) ? $netSaleTotalArray[$month] : [];
    //             $averageNetSales[] = count($dailyNetSales) > 0 ? (array_sum($dailyNetSales) / count($dailyNetSales)) : 0;
    //         }
    //     }

    //     $html = '';
    //     $html = view('reports.order_chart_data', compact('TotalOrder', 'PurchasedProductItemTotal', 'TotalgrossSale', 'currency', 'TotalNetSale', 'TotalCouponAmount', 'TotalShippingCharge'))->render();

    //     $return['html'] = $html;

    //     $return['TotalOrderCount'] = $TotalOrderCount;
    //     $return['NetSaleTotal'] = $NetSaleTotal;
    //     $return['AverageNetSales'] = $averageNetSales;
    //     $return['GrossSaleTotal'] = $GrossSaleTotal;
    //     $return['AverageGrossSales'] = $averageGrossSales;
    //     $return['PurchasedItemTotal'] = $PurchasedItemTotal;
    //     $return['ShippingTotal'] = $ShippingTotal;
    //     $return['CouponTotal'] = $CouponTotal;
    //     $return['monthList'] = $monthList;
    //     Session::put('order_line_chart_report', $return);

    //     return response()->json($return);
    // }
}
