<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Plan;
use App\Models\Store;
use App\Models\Utility;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user() && auth()->user()->isAbleTo('Manage User'))
        {
            $users = User::where('role', 2)->get();

            return view('users.index',compact('users'));

        }
        else{
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user() && auth()->user()->isAbleTo('Create User'))
        {
            $user  = \Auth::user();
            $roles = [];
            return view('users.create',compact('roles'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function store(Request $request)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Create User'))
        {
            $exitUser = User::where('email', $request->email)->first();
            if ($exitUser && $exitUser->created_by != auth()->user()->id) {
                return redirect()->back()->with('error', __('The email is already being used in another account. please choose another email'));
            }
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => [
                        'required',
                        Rule::unique('users')
                    ],
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $user = \Auth::user();
            $creator = User::find($user->creatorId());
            
            if (1)
            {

                $objUser    = \Auth::user();
                
                $user =  new User();
                $user->name =  $request['name'];
                $user->email =  $request['email'];
                $user->role = 2;
                $user->password = Hash::make($request['password']);
                
               
                $user->email_verified_at = date("Y-m-d H:i:s");
                
                
                $user->save();

                
                
                return redirect()->back()->with('success', 'User successfully created.');
            } else {
                return redirect()->back()->with('error', __('Your User limit is over, Please upgrade plan'));
            }
        }
        else{
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    
    public function edit($id)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Edit User'))
        {
            $user  = User::find($id);
            
            return view('users.edit', compact('user'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function update(Request $request, $id)
    {

        if (auth()->user() && auth()->user()->isAbleTo('Edit User'))
        {
            $user = User::findOrFail($id);

            $exitUser = User::where('email', $request->email)->where('id', '!=', $id)->first();
            if ($exitUser && $exitUser->created_by != auth()->user()->id) {
                return redirect()->back()->with('error', __('The email is already being used in another account. please choose another email'));
            }

            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required'
                   
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

                
            
            $user->name =  $request['name'];
            $user->email =  $request['email'];

            if (isset($request['password']) && !empty($request['password']))
            $user->password = Hash::make($request['password']);
            
            
            $user->save();

            
            return redirect()->back()->with('success', 'User successfully updated.');
        }
        else{
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy(User $user)
    {

        if (auth()->user() && auth()->user()->isAbleTo('Delete User'))
        {
            
            $user->delete();

            return redirect()->back()->with('success', 'User successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function userLoginManage($id)
    {
        $eId = \Crypt::decrypt($id);
        $user = User::find($eId);
        if ($user->is_enable_login == 1) {
            $user->is_enable_login = 0;
            $message = __('User login disable successfully.');
        } else {
            $user->is_enable_login = 1;
            $message = __('User login enable successfully.');
        }
        $user->save();

        return redirect()->back()->with('success', $message);
    }
}
