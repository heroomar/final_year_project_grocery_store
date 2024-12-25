<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\FlashSale;
use App\Models\Store;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\OrderBillingDetail;
use App\DataTables\CustomerDataTable;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CustomerDataTable $dataTable, Request $request)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Manage Customer')) {
            
            return $dataTable->with('request', $request)->render('customer.index',);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request){
        $validator = \Validator::make(
            $request->all(), [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required',
                    'mobile' => 'required',
                    'date_of_birth' => 'required',
                            ]
        );
        

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $path['full_url'] = '';
        if ($request->photo){
            $dir        = 'themes/'.APP_THEME().'/uploads';
            $fileName = rand(1111,9999).'_'.time() . "_" . $request->photo->getClientOriginalName();
            $path = Utility::upload_file($request,'photo',$fileName,$dir,[]);
        }
        
        $Customer = new Customer();

        $Customer->first_name = $request->first_name; 
        $Customer->last_name = $request->last_name; 
        $Customer->email = $request->email; 
        $Customer->profile_image = $path['full_url']; 
        $Customer->mobile = $request->mobile; 
        $Customer->regiester_date = now(); 
        $Customer->date_of_birth = $request->date_of_birth; 
        $Customer->created_by = auth()->id(); 
        $Customer->theme_id = APP_THEME(); 
        $Customer->store_id = getCurrentStore(); 

        $Customer->save();

        $user =  new User();
        $user->name =  $request->first_name;
        $user->email =  $request->email;
        $user->role = 3;
        $user->password = Hash::make($request->email);
        
        
        $user->email_verified_at = date("Y-m-d H:i:s");
        
        
        $user->save();


        return redirect(route('customer.index'))->with('success', __('Customer successfully created.'));
    }

    // /**
    //  * Display the specified resource.
    //  */
    public function show($id)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Show Customer')) {
            
                $orders = Order::where('customer_id', $id)->get();
                $customer = Customer::find($id);
            return view('customer.view', compact('orders','customer'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request,$id){
        $validator = \Validator::make(
            $request->all(), [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required',
                    'mobile' => 'required',
                    'date_of_birth' => 'required',
                            ]
        );
        

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $Customer = Customer::find($id);

        $path['full_url'] = '';
        if ($request->photo){
            $dir        = 'themes/'.APP_THEME().'/uploads';
            $fileName = rand(1111,9999).'_'.time() . "_" . $request->photo->getClientOriginalName();
            $path = Utility::upload_file($request,'photo',$fileName,$dir,[]);
            $Customer->profile_image = $path['full_url'] ?? '';
        }
        
        
        $Customer->first_name = $request->first_name; 
        $Customer->last_name = $request->last_name; 
        $Customer->email = $request->email; 
         
        $Customer->mobile = $request->mobile; 
        $Customer->date_of_birth = $request->date_of_birth; 
        
        $Customer->save();
        return redirect(route('customer.index'))->with('success', __('Customer successfully edited.'));
    }

    public function destroy(Customer $customer)
    {

        if(auth()->user() && auth()->user()->isAbleTo('Delete Customer'))
        {
                $customer->delete();

            return redirect()->back()->with('success', __('Customer delete successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // public function customerStatus(Request $request)
    // {
    //     $customer = Customer::find($request->customer_id);
    //     $customer->status = $request->status;
    //     $customer->save();

    //     return response()->json(['success' => __('Status change successfully.')]);
    // }

    // public function customerTimeline($ids)
    // {
    //     $activityLog = ActivityLog::where('customer_id', $ids)
    //         ->groupBy('customer_id')
    //         ->first();

    //     $logs = ActivityLog::where('customer_id', $ids)->get();

    //     $totalSpend = ActivityLog::totalspend($ids);

    //     $customer_data = Customer::find($ids);


    //     return view('customer.timeline', compact('logs', 'activityLog', 'totalSpend', 'customer_data'));
    // }


    // public function CustomFilter(Request $request)
    // {
    //     $id = $request->customer_field;
    //     $data = [];
    //     if ($id == 'Name' || $id == 'Email') {
    //         $data['condition'] = Customer::$fields_status;
    //         $data['message']  = __("Customer name and email search filed");
    //     } else if ($id == 'Last active') {
    //         $data['condition'] = Customer::$fields_status1;
    //         $data['message']  = __("Customer last active search filed");
    //     } else if ($id == 'Total Spend' || $id == 'No. of Orders' || $id == "AOV") {
    //         $data['condition'] = Customer::$fields_status2;
    //         $data['message']  = __("Customer last active search filed");
    //     } else {
    //         $data['condition'] = [];
    //         $data['message']  = __("Customer condition search filed");
    //     }

    //     if ($id == 'Name') {
    //         $data['field_type'] = 'text';
    //     } else if ($id == 'Last active') {
    //         $data['field_type'] = 'date';
    //     } else if ($id == 'Email') {
    //         $data['field_type'] = 'email';
    //     } else {
    //         $data['field_type'] = 'number';
    //     }
    //     return response()->json($data);
    // }

    // public function CustomFilterData(Request $request)
    // {
    //     $activitylog = ActivityLog::groupBy('customer_id')->where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->get();

    //     $requestData = $request->all();

    //     $query = Customer::where('theme_id', APP_THEME())->where('store_id', getCurrentStore());
    //     if ($requestData['customer_field'] == 'Name' || $requestData['customer_field'] == 'Email') {
    //         if (!empty($requestData['selected_name']) && !empty($requestData['text_field'])) {
    //             // check for name and email filtering
    //             if ($requestData['selected_name'] === 'Includes') {
    //                 $query->where(function ($query) use ($requestData) {
    //                     $query->where('first_name', 'like', '%' . $requestData['text_field'] . '%')
    //                         ->orWhere('email', 'like', '%' . $requestData['text_field'] . '%');
    //                 });
    //             } elseif ($requestData['selected_name'] === 'Excludes') {
    //                 $query->where(function ($query) use ($requestData) {
    //                     $query->where(function ($query) use ($requestData) {
    //                         $query->where('first_name', 'not like', '%' . $requestData['text_field'] . '%')
    //                             ->orWhere('email', 'not like', '%' . $requestData['text_field'] . '%');
    //                     });
    //                 });
    //             }
    //         }
    //     }

    //     // Check for last active filtering
    //     if ($requestData['customer_field'] == 'Last Active') {
    //         if (!empty($requestData['selected_name']) && !empty($requestData['text_field'])) {
    //             $dateValue = $requestData['text_field'];
    //             if ($requestData['selected_name'] === 'Before') {
    //                 $query->whereDate('last_active', '<', $dateValue);
    //             } elseif ($requestData['selected_name'] === 'After') {
    //                 $query->whereDate('last_active', '>', $dateValue);
    //             } else {
    //                 $query->whereDate('last_active', $dateValue);
    //             }
    //         }
    //     }

    //     // check for AOV filtering
    //     if ($requestData['customer_field'] == 'AOV') {
    //         $queryyy = Customer::where('theme_id', APP_THEME())->where('store_id', getCurrentStore());
    //         if (!empty($requestData['selected_name']) && !empty($requestData['text_field'])) {
    //             $filteredCustomers = [];
    //             foreach ($queryyy->get() as $key => $value) {
    //                 $AOV = 0;
    //                 if ($value->total_spend() != 0 && $value->Ordercount() != 0) {
    //                     $AOV = number_format($value->total_spend() / $value->Ordercount(), 2);

    //                     // Check the condition and filter
    //                     $text_field_float = (float) $requestData['text_field'];
    //                     $AOV = (float) str_replace(',', '', $AOV);
    //                     if ($requestData['selected_name'] === 'Less Than' && $AOV < $text_field_float) {
    //                         $filteredCustomers[] = $value->id;
    //                     } elseif ($requestData['selected_name'] === 'More Than' && $AOV > $text_field_float) {
    //                         $filteredCustomers[] = $value->id;
    //                     } elseif ($requestData['selected_name'] === 'Equal' && $AOV = $text_field_float) {
    //                         $filteredCustomers[] = $value->id;
    //                     }
    //                 }
    //             }
    //             $query = $queryyy->whereIn('id', $filteredCustomers);
    //         }
    //     }

    //     // check for number of orders filtering
    //     if ($requestData['customer_field'] == 'No. of Orders') {
    //         $queryss = Customer::where('theme_id', APP_THEME())->where('store_id', getCurrentStore());
    //         if (!empty($requestData['selected_name']) && !empty($requestData['text_field'])) {
    //             $filteredCustomers = [];

    //             $orderCountValue = (int) $requestData['text_field'];
    //             foreach ($queryss->get() as $key => $value) {
    //                 $counter = $value->Ordercount();

    //                 if ($requestData['selected_name'] === 'Less Than' && $counter < $orderCountValue) {
    //                     $filteredCustomers[] = $value->id;
    //                 } else if ($requestData['selected_name'] === 'Less Than' && $counter > $orderCountValue) {
    //                     $filteredCustomers[] = $value->id;
    //                 } else if ($requestData['selected_name'] === 'Equal' && $counter == $orderCountValue) {
    //                     $filteredCustomers[] = $value->id;
    //                 }
    //             }
    //             $query = $queryss->whereIn('id', $filteredCustomers);
    //         }
    //     }

    //     // check for Total Spend filtering
    //     if ($requestData['customer_field'] == 'Total Spend') {
    //         $queryes = Customer::where('theme_id', APP_THEME())->where('store_id', getCurrentStore());
    //         if (!empty($requestData['selected_name']) && !empty($requestData['text_field'])) {
    //             $filteredCustomers = [];

    //             $orderCountValue = (int) $requestData['text_field'];
    //             foreach ($queryes->get() as $key => $value) {
    //                 $counter = $value->total_spend();

    //                 if ($requestData['selected_name'] === 'Less Than' && $counter < $orderCountValue) {
    //                     $filteredCustomers[] = $value->id;
    //                 } else if ($requestData['selected_name'] === 'Less Than' && $counter > $orderCountValue) {
    //                     $filteredCustomers[] = $value->id;
    //                 } else if ($requestData['selected_name'] === 'Equal' && $counter == $orderCountValue) {
    //                     $filteredCustomers[] = $value->id;
    //                 }
    //             }
    //             $query = $queryes->whereIn('id', $filteredCustomers);
    //         }
    //     }
    //     $customers = $query->get();

    //     $filter = view('customer.filter', compact('customers', 'activitylog'))->render();

    //     return response()->json($filter);
    // }
}
