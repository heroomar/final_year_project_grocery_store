<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Theme;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\ShopifyConection;
use App\Models\WoocommerceConection;
use App\DataTables\SubCategoryDataTable;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(SubCategoryDataTable $dataTable)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Manage Product Sub Category'))
        {
            return  $dataTable->render('subcategory.index');
        }
        else
        {
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
        $MainCategoryList = MainCategory::pluck('name', 'id');
        // dd($MainCategoryList);
        return view('subcategory.create', compact('MainCategoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Create Product Sub Category'))
        {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'maincategory_id' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $dir        = 'themes/'.APP_THEME().'/uploads';
            if($request->image) {
                $image_size = $request->file('image')->getSize();
                
                
                    $fileName = rand(10,100).'_'.time() . "_" . $request->image->getClientOriginalName();
                    $path = Utility::upload_file($request,'image',$fileName,$dir,[]);
                
            }else{
                $path['full_url'] = asset(Storage::url('uploads/default.jpg'));
                $path['url'] = Storage::url('uploads/default.jpg');
            }
            if($request->icon_path) {
                $image_size = $request->file('icon_path')->getSize();
                
                $fileName = rand(10,100).'_'.time() . "_" . $request->icon_path->getClientOriginalName();
                $paths = Utility::upload_file($request,'icon_path',$fileName,$dir,[]);
                

            }else{
                $paths['url'] = Storage::url('uploads/default.jpg');
            }


            $subcategory                    = new SubCategory();
            $subcategory->name              = $request->name;
            $subcategory->maincategory_id   = $request->maincategory_id;
            $subcategory->image_url         = $path['full_url'];
            $subcategory->image_path        = $path['url'];
            $subcategory->icon_path        = $paths['url'];
            $subcategory->status            = $request->status;
            $subcategory->theme_id          = APP_THEME();
            $subcategory->store_id          = getCurrentStore();
            $subcategory->save();

            return redirect()->back()->with('success', __('Category successfully created.'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        $MainCategoryList = MainCategory::where('status', 1)->where('theme_id',APP_THEME())->where('store_id',getCurrentStore())->pluck('name', 'id')->prepend('', 'Select Category');
        return view('subcategory.edit', compact('MainCategoryList', 'subCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Edit Product Sub Category'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'maincategory_id' => 'required',
                    'status' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $dir        = 'themes/'.APP_THEME().'/uploads';
            if(!empty($request->icon_path)){
                $file_path =  $subCategory->icon_path;
                $image_size = $request->file('icon_path')->getSize();
                
                    if (!empty($file_path) && $file_path != '/storage/uploads/default.jpg' && Storage::exists($file_path)) {
                        Storage::delete($file_path);
                        Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);
                    }

                    $fileName = rand(10,100).'_'.time() . "_" . $request->icon_path->getClientOriginalName();
                    $paths = Utility::upload_file($request,'icon_path',$fileName,$dir,[]);
                    if($paths['msg'] == 'success') {
                                $subCategory->icon_path   = $paths['url'];
                            }
                

            }
            if(!empty($request->image)) {
                $file_path =  $subCategory->image_path;
                $image_size = $request->file('image')->getSize();
                
                    if (!empty($file_path) && $file_path != '/storage/uploads/default.jpg' && Storage::exists($file_path)) {
                        Storage::delete($file_path);
                        Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);
                    }

                    $fileName = rand(10,100).'_'.time() . "_" . $request->image->getClientOriginalName();
                    $path = Utility::upload_file($request,'image',$fileName,$dir,[]);
                    if($path['msg'] == 'success') {
                        $subCategory->image_url    = $path['full_url'];
                        $subCategory->image_path   = $path['url'];
                    }
                
            }

            $subCategory->name              = $request->name;
            $subCategory->maincategory_id   = $request->maincategory_id;
            $subCategory->status            = $request->status;
            $subCategory->save();

            return redirect()->back()->with('success', __('Category successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {

        if (auth()->user() && auth()->user()->isAbleTo('Delete Product Sub Category'))
        {
            $category = $subCategory;

            $file_path1[] =  $subCategory->image_path;
            $file_path2[] =  $subCategory->icon_path;
            $file_path    =   array_merge($file_path1 ,$file_path2);
            
            if ($subCategory->image_path !== '/storage/uploads/default.jpg' && File::exists(base_path($subCategory->image_path))) {
                File::delete(base_path($subCategory->image_path));
                Utility::changeproductStorageLimit(\Auth::user()->creatorId(), $file_path );
            }

            if ($subCategory->icon_path !== '/storage/uploads/default.jpg' && File::exists(base_path($subCategory->icon_path))) {
                File::delete(base_path($subCategory->icon_path));
                Utility::changeproductStorageLimit(\Auth::user()->creatorId(), $file_path );
            }
            
            $subCategory->delete();
            return redirect()->back()->with('success', __('Sub category delete successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
