<?php

namespace App\Http\Controllers;

use App\Exports\CouponExport;
use App\Models\Coupon;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ShopifyConection;
use App\Models\WoocommerceConection;
use App\DataTables\CouponDataTable;
use App\DataTables\UserCouponDataTable;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CouponDataTable $dataTable)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Manage Coupon')) {
            return $dataTable->render('coupon.index');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = Product::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->toArray();
        $category = MainCategory::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->toArray();

        return view('coupon.create', compact('product', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Create Coupon')) {
            

            if ($request->coupon_type == 'percentage') {
                $validator = \Validator::make($request->all(), [
                    'discount_amount' => 'required|numeric|min:1|max:100',
                ]);
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
            }

            $validator = \Validator::make(
                $request->all(),
                [
                    'coupon_name' => 'required|unique:coupons,coupon_name',
                    'coupon_type' => 'required',
                    'discount_amount' => 'required',
                    'coupon_expiry_date' => 'required',
                    'coupon_code' => 'required|unique:coupons,coupon_code',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $coupon = new Coupon();
            $coupon->coupon_name = $request->coupon_name;
            $coupon->coupon_type = $request->coupon_type;
            $coupon->discount_amount = $request->discount_amount;
            $coupon->coupon_expiry_date = $request->coupon_expiry_date;
            $coupon->coupon_code = trim($request->coupon_code);
            $coupon->status = 1;
            $coupon->theme_id = APP_THEME();
            $coupon->store_id = getCurrentStore();
            $coupon->save();

            return redirect()->back()->with('success', __('Coupon successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UserCouponDataTable $dataTable, Coupon $coupon)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Create Coupon')) {
              // Set the Coupon ID for filtering
              $dataTable->setCouponId($coupon->id);
            return $dataTable->render('coupon.show');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        $product = Product::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->toArray();
        $category = MainCategory::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->toArray();
        $applied_product = explode(',', $coupon->applied_product);
        $exclude_product = explode(',', $coupon->exclude_product);
        $applied_categories = explode(',', $coupon->applied_categories);
        $exclude_categories = explode(',', $coupon->exclude_categories);

        return view('coupon.edit', compact('coupon', 'product', 'category', 'applied_product', 'exclude_product', 'applied_categories', 'exclude_categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {


        if ($request->coupon_type == 'percentage') {
            $validator = \Validator::make($request->all(), [
                'discount_amount' => 'required|numeric|min:1|max:100',
            ]);
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
        }
        if (auth()->user() && auth()->user()->isAbleTo('Edit Coupon')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'coupon_name' => [
                        'required',
                        Rule::unique('coupons')->ignore($coupon->id),
                    ],
                    'discount_amount' => 'required',
                    'coupon_expiry_date' => 'required',
                    'coupon_code' => [
                        'required',
                        Rule::unique('coupons')->ignore($coupon->id),
                    ],
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $coupon->coupon_name = $request->coupon_name;
            $coupon->coupon_type = $request->coupon_type;

            
            $coupon->discount_amount = $request->discount_amount;
            $coupon->coupon_expiry_date = $request->coupon_expiry_date;
            $coupon->coupon_code = trim($request->coupon_code);
            $coupon->save();

            return redirect()->back()->with('success', __('Coupon successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Delete Coupon')) {
           
            $coupon->delete();

            return redirect()->back()->with('success', __('Coupon delete successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    
}
