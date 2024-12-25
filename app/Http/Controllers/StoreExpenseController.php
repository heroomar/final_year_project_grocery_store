<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreExpense as MainCategory;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\ShopifyConection;
use App\Models\WoocommerceConection;
use App\DataTables\StoreExpenseDataTable;
use Illuminate\Support\Facades\Storage;

class StoreExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(StoreExpenseDataTable $dataTable)
    {
        
            return  $dataTable->render('storeexpense.index');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('storeexpense.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(1)
        {
            

            $validator = \Validator::make(
                $request->all(), [
                                   'account' => 'required',
                                   'amount' => 'required',
                                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }


            $MainCategory = new MainCategory();
            $MainCategory->account         = $request->account;
            $MainCategory->description         = $request->description;
            $MainCategory->amount         = $request->amount;

            $MainCategory->save();

            return redirect()->back()->with('success', __('Category successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

}
