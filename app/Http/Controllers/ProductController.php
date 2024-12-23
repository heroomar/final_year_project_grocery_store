<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Shipping;
use App\Models\Tax;
use App\Models\Tag;
use App\Models\Setting;
use App\Models\User;
use App\Models\Plan;
use App\Models\Utility;
use App\Models\Store;
use App\Models\ProductAttributeOption;
use App\Models\ProductAttribute;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\ProductBrand;
use App\Models\ProductLabel;
use Illuminate\Support\Facades\File;
use App\Models\NotifyUser;
use App\Models\ShopifyConection;
use App\Models\WoocommerceConection;
use App\DataTables\ProductDataTable;
use Illuminate\Support\Facades\Cache;
use App\Models\TaxOption;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,ProductDataTable $dataTable)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Manage Products')) {
            $products = Product::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->orderBy('id', 'desc')->get();
            
            if ($request->id == 1) {
                $msg = __('Product Successfully Created');
                return  $dataTable->render('product.index', compact('products' , 'msg'));
            } elseif ($request->id == 2) {
                $msg = __('Product Successfully Updated');
                return  $dataTable->render('product.index', compact('products', 'msg'));
            } else {
                $msg = 0;
                return  $dataTable->render('product.index', compact('products', 'msg'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $link = env('APP_URL') .'/product/';
        $MainCategory = MainCategory::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Select Category', '');
        
        $preview_type = [
            'Video File' => 'Video File',
            'Video Url' => 'Video Url',
            'iFrame' => 'iFrame'
        ];
        return view('product.create', compact('link', 'MainCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if (auth()->user() && auth()->user()->isAbleTo('Create Product')) {
            // try {
                $user = \Auth::user();
                
                
                $store_id = getCurrentStore();

                
                    $rules = [
                        'name' => 'required',
                        'maincategory_id' => 'required',
                        'cover_image' => 'required',
                        'product_image' => 'required',
                    ];
                
                $validator = \Validator::make($request->all(), $rules,[
                     'sale_price.lt' => __('The sale price must be less than the regular price.')
                ]);

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    $msg['flag'] = 'error';
                    $msg['msg'] = $messages->first();

                    return $msg;
                }

                $dir        = 'themes/' . APP_THEME() . '/uploads';
                if (1) {
                    if (1) {
                        $input = $request->all();
                        
                        $Product = new Product();
                        $Product->name = $request->name;
                        if (isset($request->slug) && !empty($request->slug)) {
                            $Product->slug = $request->slug;
                        } else {
                            $Product->slug = str_replace(' ','-',$request->name);
                        }

                        $Product->maincategory_id = $request->maincategory_id;
                        $Product->subcategory_id = $request->subcategory_id;
                        

                        if ($request->cover_image) {

                            $image_size = $request->file('cover_image')->getSize();
                            
                            if (1) {
                                $fileName = rand(10, 100) . '_' . time() . "_" . $request->cover_image->getClientOriginalName();
                                $path = Utility::upload_file($request, 'cover_image', $fileName, $dir, []);
                            } 

                            $Product->cover_image_path = $path['url'] ?? null;
                            $Product->cover_image_url = $path['full_url'] ?? null;
                        }

                        $Product->product_weight = $request->product_weight;
                        $Product->status = 1;
                        $Product->description = $request->description;
                        $Product->specification = $request->specification;
                        $Product->detail = $request->detail;
                        $Product->price = $request->price;
                        $Product->sale_price = $request->sale_price;

                        $Product->product_stock = !empty($request->product_stock) ? $request->product_stock : 0;
                        
                        
                        $Product->store_id = getCurrentStore();
                        $Product->theme_id = APP_THEME();
                        $Product->created_by = \Auth::user()->id;
                        

                        $Product->save();
                        
                        foreach ($request->product_image as $key => $image) {
                            $theme_image = $image;

                            $image_size = File::size($theme_image);
                            if (1) {
                                $fileName = rand(10, 100) . '_' . time() . "_" . $image->getClientOriginalName();
                                $pathss = Utility::keyWiseUpload_file($request, 'product_image', $fileName, $dir, $key, []);
                            }

                            if (isset($pathss['url'])) {
                                $ProductImage = new ProductImage();
                                $ProductImage->product_id = $Product->id;
                                $ProductImage->image_path = $pathss['url'];
                                $ProductImage->image_url  = $pathss['full_url'];
                                $ProductImage->theme_id   = $store_id;
                                $ProductImage->store_id   = getCurrentStore();
                                $ProductImage->save();
                            }
                        }
                    } 
                }

                $msg['flag'] = 'success';
                $msg['msg'] =  __('Product saved successfully.');
                return $msg;
            // } catch (\Exception $e) {
            //     \Log::info(['error' => $e]);
            //     $msg['flag'] = 'error';
            //     $msg['msg'] = $e->getMessage();
            //     return $msg;
            // }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(Product $product)
    // {
        
    //     $link = env('APP_URL') .'/product/';
    //     $MainCategory = MainCategory::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Select Category', '');
    //     $SubCategory = SubCategory::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Select Category', '');
    //     $Tax = Tax::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id');
    //     $Tax_status = Tax::Taxstatus();
    //     $Shipping = Shipping::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Select Shipping', '');
    //     $preview_type = [
    //         'Video File' => 'Video File',
    //         'Video Url' => 'Video Url',
    //         'iFrame' => 'iFrame'
    //     ];
    //     $ProductAttribute = ProductAttribute::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id');
    //     $product_image = ProductImage::where('product_id', $product->id)->where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->get();
    //     $get_tax = explode(',', $product->tax_id);
    //     $get_datas = explode(',', $product->attribute_id);
    //     $tag = Tag::where('store_id', getCurrentStore())->where('theme_id', APP_THEME())->pluck('name', 'id');
    //     $get_tags = explode(',', $product->tag_id);

    //     $brands = ProductBrand::where('status', 1)->where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Select Brand', '');
    //     $labels = ProductLabel::where('status', 1)->where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Select Label', '');

    //     $compact = ['link', 'product', 'MainCategory', 'Tax', 'Tax_status', 'Shipping', 'preview_type', 'ProductAttribute', 'SubCategory', 'product_image', 'get_tax', 'get_datas', 'tag', 'get_tags', 'brands', 'labels'];
    //     return view('product.show', compact($compact));
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    public function edit(Product $product)
    {
         
        $link = env('APP_URL') .'/product/';
        $MainCategory = MainCategory::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Select Category', '');
        $SubCategory = SubCategory::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Select Category', '');
        $product_image = ProductImage::where('product_id', $product->id)->where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->get();
        
        $compact = ['link', 'product', 'MainCategory', 'SubCategory', 'product_image'];
        return view('product.edit', compact($compact));
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    public function update(Request $request, Product $product)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Edit Products')) {
            $dir        = 'themes/' . APP_THEME() . '/uploads';
                $rules = [
                    'name' => 'required',
                    'maincategory_id' => 'required',
                    'price' => 'numeric|min:0',
                    
                ];
            
            
            $validator = \Validator::make($request->all(), $rules,[
                'sale_price.lt' => __('The sale price must be less than the regular price.')
           ]);
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                $msg['flag'] = 'error';
                $msg['msg'] =  $messages->first();
                return $msg;
            }

            if ($request->cover_image) {
                $image_size = $request->file('cover_image')->getSize();
                $file_path =  $product->cover_image_path;

                $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                if ($result == 1) {
                    Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);

                    $fileName = rand(10, 100) . '_' . time() . "_" . $request->cover_image->getClientOriginalName();
                    $path = Utility::upload_file($request, 'cover_image', $fileName, $dir, []);
                    if (File::exists(base_path($product->cover_image_path))) {
                        File::delete(base_path($product->cover_image_path));
                    }
                } else {
                    $msg['flag'] = 'error';
                    $msg['msg'] = $result;

                    return $msg;
                }
                $product->cover_image_path = $path['url'];
                $product->cover_image_url = $path['full_url'];
            }



            $product->name = $request->name;
            if (isset($request->slug) && !empty($request->slug)) {
                $product->slug = $request->slug;
            } else {
                $product->slug = str_replace(' ','-',$request->name);
            }
            $product->description = $request->description;
            $product->specification = $request->specification;
            $product->detail = $request->detail;
            $product->product_weight = $request->product_weight;
            $product->maincategory_id = $request->maincategory_id;
            $product->subcategory_id = $request->subcategory_id;
            
            $product->status = 1;
            

            if (!empty($request->product_image)) {

                foreach ($request->product_image as $key => $image) {
                    $theme_image = $image;

                    $image_size = File::size($theme_image);
                    $fileName = rand(10, 100) . '_' . time() . "_" . $image->getClientOriginalName();
                    $pathss = Utility::keyWiseUpload_file($request, 'product_image', $fileName, $dir, $key, []);
                    

                    if (isset($pathss['url'])) {
                        $ProductImage = new ProductImage();
                        $ProductImage->product_id = $product->id;
                        $ProductImage->image_path = $pathss['url'];
                        $ProductImage->image_url  = $pathss['full_url'];
                        $ProductImage->theme_id   = APP_THEME();
                        $ProductImage->store_id   = getCurrentStore();
                        $ProductImage->save();
                    }
                }
            }

           
                $product->price = $request->price;
                $product->sale_price = $request->sale_price;
                $product->product_stock = $request->product_stock;
                


                $input = $request->all();


                

                $product->save();
            
            $msg['flag'] = 'success';
            $msg['msg'] =__('Product update successfully.');
            return $msg;
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    public function destroy(Product $product)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Delete Products')) {
            $ProductImages = ProductImage::where('product_id', $product->id)->get();

            $Product = Product::find($product->id);
            $file_path1 = [];
            foreach ($ProductImages as $key => $ProductImage) {
                $file_path1[] =  $ProductImage->image_path;
            }
            $file_paths2[] = $Product->cover_image_path;
            $file_path = array_merge($file_path1, $file_paths2);
            if (!empty($ProductImages)) {
                // image remove from product variant image
                foreach ($ProductImages as $key => $ProductImage) {
                    if (File::exists(base_path($ProductImage->image_path))) {
                        File::delete(base_path($ProductImage->image_path));
                    }
                }
            }

            ProductImage::where('product_id', $product->id)->delete();

            
              Product::where('id', $product->id)->delete();
            return redirect()->back()->with('success', __('Product delete successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // public function get_slug(Request $request)
    // {
    //     $result = Product::slugs($request->value);
    //     return response()->json(['result' => $result]);
    // }

    public function get_subcategory(Request $request)
    {
        $id = $request->id;
        $value = $request->val;
        $SubCategory = SubCategory::where('maincategory_id', $id)->get();
        $option = '<option value="">' . __('Select Sub-Category') . '</option>';
        foreach ($SubCategory as $key => $Category) {
            $select = $value == $Category->id ? 'selected' : '';
            $option .= '<option value="' . $Category->id . '" ' . $select . '>' . $Category->name . '</option>';
        }

        $select =  '<select class="form-control" data-role="tagsinput" id="subcategory_id" name="subcategory_id">' . $option . '</select>';
        $return['status'] = true;
        $return['html'] = $select;
        return response()->json($return);
    }

    public function show(Request $request,$id){
        $product = Product::find($id);
        return view('front.product_show',compact('product'));
    }

    // public function attribute_option(Request $request)
    // {
    //     $Attribute_option = ProductAttributeOption::where('attribute_id', $request->attribute_id)->where('theme_id', APP_THEME())->where('store_id', getCurrentStore())
    //         ->get()->pluck('terms', 'id')->toArray();

    //     return response()->json($Attribute_option);
    // }

    // public function attribute_combination(Request $request)
    // {

    //     $options = array();
    //     $unit_price = !empty($request->price) ? $request->price : 0;
    //     $product_name = !empty($request->sku) ? $request->sku : '';
    //     $stock = !empty($request->product_stock) ? $request->product_stock : 0;
    //     $input = $request->all();

    //     foreach ($request->attribute_no as $key => $no) {
    //         $forVariationName = 'for_variation_' . $no;
    //         $for_variation = isset($request->{'for_variation_' . $no}) ? $request->{'for_variation_' . $no} : 0;

    //         if ($request->has($forVariationName) && $request->input($forVariationName) == 1) {
    //             $name = 'attribute_options_' . $no;
    //             $value = 'options_' . $no;
    //             if ($for_variation == 1) {
    //                 if ($request->has($name) && is_array($request[$name])) {
    //                     $my_str = $request[$name];
    //                     $optionValues = [];

    //                     foreach ($request[$name] as $id) {
    //                         $option = ProductAttributeOption::where('id', $id)->first();

    //                         if ($option) {
    //                             $optionValues[] = $option->terms;
    //                         }
    //                     }

    //                     array_push($options, $optionValues);
    //                 }
    //             }
    //         }
    //     }

    //     $combinations = $this->combination($options);

    //     $Shipping = Shipping::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Same as Parent', '');

    //     return view('product.attribute_combinations', compact('combinations', 'input', 'unit_price', 'product_name', 'stock', 'Shipping'));
    // }

    // public function sku_combination(Request $request)
    // {
    //     $options = array();
    //     $unit_price = !empty($request->price) ? $request->price : 0;
    //     $product_name = !empty($request->sku) ? $request->sku : '';
    //     $stock = !empty($request->product_stock) ? $request->product_stock : 0;

    //     if ($request->has('choice_no')) {
    //         foreach ($request->choice_no as $key => $no) {
    //             $name = 'choice_options_' . $no;
    //             $my_str = implode('', $request[$name]);
    //             array_push($options, explode(',', $my_str));
    //         }
    //     }
    //     $combinations = $this->combinations($options);
    //     return view('product.sku_combinations', compact('combinations', 'unit_price', 'product_name', 'stock'));
    // }

    // public function attribute_combination_data(Request $request)
    // {
    //     $product_stock = ProductVariant::where('product_id', $request->id)->where('theme_id', APP_THEME())->where('store_id', getCurrentStore())
    //         ->get();
    //     $Shipping = Shipping::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Same as parent', '');
    //     return view('product.attribute_combinations_data', compact('product_stock', 'Shipping'));
    // }

    // public function combinations($arrays)
    // {

    //     $result = array(array());
    //     foreach ($arrays as $property => $property_values) {
    //         $tmp = array();
    //         foreach ($result as $result_item) {
    //             foreach ($property_values as $property_value) {
    //                 $tmp[] = array_merge($result_item, array($property => $property_value));
    //             }
    //         }
    //         $result = $tmp;
    //     }
    //     return $result;
    // }

    // public function combination($arrays)
    // {
    //     $result = array(array());
    //     foreach ($arrays as $property => $property_values) {
    //         $tmp = array();
    //         foreach ($result as $result_item) {
    //             foreach ($property_values as $property_value) {
    //                 $tmp[] = array_merge($result_item, array($property => $property_value));
    //             }
    //         }
    //         $result = $tmp;
    //     }
    //     return $result;
    // }

    public function file_delete($id)
    {

        $product_img_id = ProductImage::find($id);
        if ($product_img_id) {
            if (File::exists(base_path($product_img_id->image_path))) {
                File::delete(base_path($product_img_id->image_path));
            }
            $product_img_id->delete();
        }

        $msg['flag'] = 'success';
        $msg['msg'] = __('Image delete Successfully');
        return $msg;
    }

    // public function attribute_combination_edit(Request $request)
    // {
    //     $product = Product::find($request->id);
    //     $options = array();
    //     $product_name = !empty($request->sku) ? $request->sku : '';
    //     $unit_price = !empty($request->price) ? $request->price : 0;

    //     foreach ($request->attribute_no as $key => $no) {
    //         $forVariationName = 'for_variation_' . $no;
    //         $for_variation = isset($request->{'for_variation_' . $no}) ? $request->{'for_variation_' . $no} : 0;
    //         if ($for_variation == 1) {
    //             if ($request->has($forVariationName) && $request->input($forVariationName) == 1) {
    //                 $name = 'attribute_options_' . $no;

    //                 if ($request->has($name) && is_array($request[$name])) {
    //                     $my_str = $request[$name];
    //                     $optionValues = [];
    //                     array_push($options, $my_str);
    //                 }
    //             }
    //         }
    //     }

    //     $combinations = $this->combination($options);
    //     $Shipping = Shipping::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Same as parent', '');
    //     return view('product.attribute_combinations_edit', compact('combinations', 'unit_price', 'product_name', 'product', 'Shipping'));
    // }

    // public function product_attribute_delete($id)
    // {
    //     $attribute = ProductVariant::findOrFail($id);
    //     $attribute->delete();

    //     return "true";
    // }

    // public function collectionAll($storeSlug, Request $request, $list)
    // {
    // }

    // public function product_price(Request $request, $slug)
    // {
    //     return 1203;
    // }

    public function searchProducts(Request $request)
    {
        $lastsegment = $request->session_key;
        $store_id =  getCurrentStore();
        // && isset($lastsegment) && !empty($lastsegment)
        if ($request->ajax() ) {
            $output = "";
            if ($request->cat_id !== '' && $request->search == '') {
                if ($request->cat_id == '0') {
                    $products = Product::get();
                } else {
                    $products = Product::where('maincategory_id', $request->cat_id)->get();
                }
            } else {
                if ($request->cat_id == '0') {
                    $products = Product::where('name', 'LIKE', "%{$request->search}%")->get();
                } else {
                    $products = Product::where('name', 'LIKE', "%{$request->search}%")->Where('maincategory_id', $request->cat_id)->get();
                }
            }
            if (count($products) > 0) {
                foreach ($products as $key => $product) {
                    if (!empty($product->cover_image_path)) {
                        $image_url = get_file($product->cover_image_path, APP_THEME());
                    } else {
                        $image_url = ('uploads/cover_image_path') . '/default.jpg';
                    }

                    if (1) {
                        
                            $quantity = $product->product_stock;
                        if ($quantity == 0){
                            
                                $quantity = 'Out of Stock';
                            
                        } else {
                            $quantity = $product->product_stock . ' Qty';
                        }

                        if ($request->session_key == 'purchases') {
                            $productprice = get_currency().' '.($product->price);
                        } else if ($request->session_key == 'pos_' . getCurrentStore()) {
                            $productprice = get_currency().' '.($product->price);
                        } else {
                            $productprice = get_currency().' '.($product->price);
                        }

                        $productprice = $productprice;
                        $output .= ' <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-6 col-12">
                                    <div class="tab-pane fade show active toacart w-100" data-url="' . url('/addToCart/' . $product->id . '/' . $lastsegment) . '">
                                        <div class="position-relative card">
                                            <img alt="Image placeholder" src="' . asset($image_url) . '" class="card-image avatar hover-shadow-lg" style=" height: 6rem; width: 100%;">
                                            <div class="p-0 custom-card-body card-body d-flex ">
                                                <div class="card-body my-2 p-2 text-left card-bottom-content">
                                                <h6 class="mb-2 text-dark product-title-name">' . $product->name . '</h6>
                                                <p class="mb-2 text-dark product-title-name small">' . $product->slug . '</p>
                                                <small class="badge badge-primary mb-0">' . $productprice . '</small>
                                                <small class="top-badge badge badge-danger mb-0">' . $quantity . '</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> ';
                    } else {

                        $output .= ' <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-6 col-12">
                                <div class="tab-pane fade show active toacart w-100" data-url="' . url('/pos/product-variant/' . $product->id . '/' . $lastsegment) . '" data-ajax-popup="true" data-size="lg" data-align="centered" data-title="Product Variant">
                                    <div class="position-relative card">
                                        <img alt="Image placeholder" src="' . asset($image_url) . '" class="card-image avatar hover-shadow-lg" style=" height: 6rem; width: 100%;">
                                        <div class="p-0 custom-card-body card-body d-flex ">
                                            <div class="card-body my-2 p-2 text-left card-bottom-content">
                                                <h6 class="mb-2 text-dark product-title-name">' . $product->name . '</h6>
                                                <p class="mb-2 text-dark product-title-name small">' . $product->slug . '</p>
                                                <small class="badge badge-primary mb-0">In Variant</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> ';
                    }
                }
                return Response($output);
            } else {
                $output = '<div class="card card-body col-12 text-center">
                    <h5>' . __("No Product Available") . '</h5>
                    </div>';
                return Response($output);
            }
        }
    }

    public function searchProductsSku(Request $request)
    {
        $lastsegment = $request->session_key;
        $store_id =  getCurrentStore();
        if ($request->ajax() && isset($lastsegment) && !empty($lastsegment)) {
            $output = "";
            if ($request->cat_id !== '' && $request->search == '') {
                if ($request->cat_id == '0') {
                    $products = Product::where('store_id', getCurrentStore())->where('theme_id', $store_id)->get();
                } else {
                    $products = Product::where('maincategory_id', $request->cat_id)->where('store_id', getCurrentStore())->where('theme_id', $store_id)->get();
                }
            } else {
                if ($request->cat_id == '0') {
                    $products = Product::where('slug', 'LIKE', "%{$request->search}%")->where('store_id', getCurrentStore())->where('theme_id', $store_id)->get();
                } else {
                    $products = Product::where('slug', 'LIKE', "%{$request->search}%")->where('store_id', getCurrentStore())->where('theme_id', $store_id)->Where('maincategory_id', $request->cat_id)->get();
                }
            }
            if (count($products) > 0) {
                foreach ($products as $key => $product) {
                    if (!empty($product->cover_image_path)) {
                        $image_url = get_file($product->cover_image_path, APP_THEME());
                    } else {
                        $image_url = ('uploads/cover_image_path') . '/default.jpg';
                    }

                    if ($product->variant_product != '1') {
                        if ($product->track_stock == 0) {
                            $quantity = $product->stock_status;
                            if ($product->stock_status == 'in_stock') {
                                $quantity = 'In Stock';
                            } elseif ($product->stock_status == 'on_backorder') {
                                $quantity = 'On Backorder';
                            } else {
                                $quantity = 'Out of Stock';
                            }
                        } else {
                            $quantity = $product->product_stock . ' Qty';
                        }

                        if ($request->session_key == 'purchases') {
                            $productprice = getProductActualPrice($product);
                        } else if ($request->session_key == 'pos_' . getCurrentStore()) {
                            $productprice = getProductActualPrice($product);
                        } else {
                            $productprice = getProductActualPrice($product);
                        }

                        $productprice = currency_format_with_sym($productprice, $store_id, $store_id);
                        $output .= ' <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-6 col-12">
                                    <div class="tab-pane fade show active toacart w-100" data-url="' . url('/addToCart/' . $product->id . '/' . $lastsegment) . '">
                                        <div class="position-relative card">
                                            <img alt="Image placeholder" src="' . asset($image_url) . '" class="card-image avatar hover-shadow-lg" style=" height: 6rem; width: 100%;">
                                            <div class="p-0 custom-card-body card-body d-flex ">
                                                <div class="card-body my-2 p-2 text-left card-bottom-content">
                                                <h6 class="mb-2 text-dark product-title-name">' . $product->name . '</h6>
                                                <p class="mb-2 text-dark product-title-name small">' . $product->slug . '</p>
                                                <small class="badge badge-primary mb-0">' . $productprice . '</small>
                                                <small class="top-badge badge badge-danger mb-0">' . $quantity . '</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> ';
                    } 
                }
                return Response($output);
            } else {
                $output = '<div class="card card-body col-12 text-center">
                    <h5>' . __("No Product Available") . '</h5>
                    </div>';
                return Response($output);
            }
        }
    }

    public function addToCart(Request $request, $id, $session_key, $variant_id = 0)
    {
        $store_id =  getCurrentStore();

        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is not found!'),
                ],
                404
            );
        }

        $productname = $product->name;

        $variant = null;
        $productquantity = $productprice = 0;
        if(1) {
            if (
                $product->product_stock == 0 
            ) {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            $productquantity = $product->product_stock;
            if ($session_key == 'pos_' . getCurrentStore()) {

                $productprice = ($product->price);
            } else {
                $productprice = 0;
            }
        }

        $originalquantity = (int) $productquantity;

        $tax_price = 0;
        $product_tax = '';
        
        $subtotal = $productprice + $tax_price;
        $cart            = session()->get($session_key);
        if (!empty($product->cover_image_path)) {
            $image_url = get_file($product->cover_image_path, APP_THEME());
        } else {
            $image_url = ('uploads/is_cover_image') . '/default.jpg';
        }

        $model_delete_id = 'delete-form-' . $id;

        $carthtml = '';

        $carthtml .= '<tr data-product-id="' . $id . '" id="product-id-' . $id . '">
                        <td class="cart-images">
                            <img alt="Image placeholder" src="' . ($image_url) . '" class="card-image avatar shadow hover-shadow-lg">
                        </td>

                        <td class="name">' . $productname . '</td>

                        <td class="">
                                <span class="quantity buttons_added">
                                        <input type="button" value="-" class="minus">
                                        <input type="number" step="1" min="1" max="" name="quantity" title="' . __('Quantity') . '" class="input-number" size="4" data-url="' . url('update-cart/') . '" data-id="' . $id . '" style="width:50px;">
                                        <input type="button" value="+" class="plus">
                                </span>
                        </td>
                        <td class="tax">' . $product_tax . '</td>

                        <td class="price">' . (currency_format_with_sym($productprice, $store_id, $store_id) ?? SetNumberFormat($productprice)) . '</td>

                        <td class="total_orignal_price">' . (currency_format_with_sym($subtotal, $store_id, $store_id) ?? SetNumberFormat($subtotal)) . '</td>

                        <td class="">
                            <form method="post" class="mb-0" action="' . route('remove-from-cart') . '"  accept-charset="UTF-8" id="' . $model_delete_id . '">
                            <button type="button" class="show_confirm btn btn-sm btn-danger p-2">
                            <span class=""><i class="ti ti-trash"></i></span>
                            </button>
                                <input name="_method" type="hidden" value="DELETE">
                                <input name="_token" type="hidden" value="' . csrf_token() . '">
                                <input type="hidden" name="session_key" value="' . $session_key . '">
                                <input type="hidden" name="id" value="' . $id . '">
                            </form>
                        </td>
                    </td>';
        // if cart is empty then this the first product

        if (!$cart) {
            $cart = [
                $id => [
                    "product_id" => $product->id,
                    "name" => $productname,
                    "image" => $product->cover_image_path,
                    "quantity" => 1,
                    "orignal_price" => $productprice,
                    "per_product_discount_price" => $product->discount_amount,
                    "discount_price" => $product->discount_amount,
                    "final_price" => $subtotal,
                    "id" => $id,
                    "tax" => $tax_price,
                    "total_orignal_price" => $subtotal,
                    "originalquantity" => $originalquantity,
                    'variant_id' => $variant->id ?? 0,
                    "variant_name" => $product->variant_attribute,
                    "return" => 0,
                ],
            ];

            if (($originalquantity < $cart[$id]['quantity']) && $session_key != 'pos_' . getCurrentStore()) {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            session()->put($session_key, $cart);

            return response()->json(
                [
                    'code' => 200,
                    'status' => 'Success',
                    'success' => $productname . __(' added to cart successfully!'),
                    'product' => $cart[$id],
                    'carthtml' => $carthtml,
                ]
            );
        }

        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$id])) {
            $cartProduct = Product::find($id);
            $cart[$id]['quantity']++;
            $cart[$id]['id'] = $id;

            $subtotal = $cart[$id]["orignal_price"] * $cart[$id]["quantity"];
            $tax = 0;
            $taxes            = !empty($cart[$id]["tax"]) ? $cart[$id]["tax"] : '';

            $tax_price = 0;
            $product_tax = '';
            $price = $cart[$id]["orignal_price"] * $cart[$id]["quantity"];
            
            
            $productprice          = $cart[$id]["orignal_price"] ?? 0;
            $subtotal = $productprice  *  (float)$cart[$id]["quantity"];
            
            $cart[$id]["total_orignal_price"] = $subtotal;

            $cart[$id]["total_orignal_price"]         = $subtotal + $tax;
            $cart[$id]["originalquantity"] = $originalquantity;
            $cart[$id]["tax"]      = $tax_price;
            if ($product->product_stock == 0 && $session_key != 'pos_' . getCurrentStore()) {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            session()->put($session_key, $cart);

            return response()->json(
                [
                    'code' => 200,
                    'status' => 'Success',
                    'success' => $productname . __(' added to cart successfully!'),
                    'product' => $cart[$id],
                    'carttotal' => $cart,
                ]
            );
        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "product_id" => $product->id,
            "name" => $productname,
            "image" => $product->cover_image_path,
            "quantity" => 1,
            "orignal_price" => $productprice,
            "per_product_discount_price" => $product->discount_amount,
            "discount_price" => $product->discount_amount,
            "final_price" => $subtotal,
            "id" => $id,
            "tax" => $tax_price,
            "total_orignal_price" => $subtotal,
            "originalquantity" => $originalquantity,
            'variant_id' => $variant->id ?? 0,
            "variant_name" => $product->variant_attribute,
            "return" => 0,
        ];
        if (($product->product_stock != 0 && $originalquantity < $cart[$id]['quantity']) ||  $session_key != 'pos_' . getCurrentStore()) {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock!'),
                ],
                404
            );
        }

        session()->put($session_key, $cart);
        return response()->json(
            [
                'code' => 200,
                'status' => 'Success',
                'success' => $productname . __(' added to cart successfully!'),
                'product' => $cart[$id],
                'carthtml' => $carthtml,
                'carttotal' => $cart,
            ]
        );
    }

    public function updateCart(Request $request)
    {
        $id          = $request->id;
        $quantity    = $request->quantity;
        $discount    = $request->discount;
        $session_key = $request->session_key;
        $store_id = getCurrentStore();

        if ($request->ajax() && isset($id) && !empty($id) && isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);

            if (isset($cart[$id]) && $quantity == 0) {
                unset($cart[$id]);
            }

            if ($quantity && !empty($quantity)) {

                $cart[$id]["quantity"] = $quantity;
                $taxes            = !empty($cart[$id]["tax"]) ? $cart[$id]["tax"] : '';

                $price = ($cart[$id]["orignal_price"] ?? 0) * $quantity;

                $tax_option = [];
                            
                $product = Product::where('id', $id)->first();
                $tax_price = 0;
                $product_tax = '';
                
                $subtotal = $price + $tax_price;
                $cart[$id]["tax"] = $tax_price;
                $producttax = 0;
                if (!empty($taxes)) {
                    $productprice          = $cart[$id]["orignal_price"] *  (float)$quantity;
                    $subtotal = $productprice +  $tax_price;
                } else {
                    $productprice          = $cart[$id]["orignal_price"] ?? 0;
                    $subtotal = ($productprice  *  (float) $quantity) + $tax_price;
                }

                $cart[$id]["total_orignal_price"] = $subtotal;
            }

            if (isset($cart[$id]) && isset($cart[$id]["originalquantity"]) < $cart[$id]['quantity'] && $session_key == 'pos_' . getCurrentStore()) {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            $subtotal = array_sum(array_column($cart, 'total_orignal_price'));
            $discount = $request->discount;
            $total = $subtotal - (float)$discount;
            $totalDiscount = currency_format_with_sym($total, $store_id, $store_id) ?? SetNumberFormat($total);
            $discount = $totalDiscount;

            session()->put($session_key, $cart);
            return response()->json(
                [
                    'code' => 200,
                    'success' => __('Cart updated successfully!'),
                    'product' => $cart,
                    'discount' => $discount,
                ]
            );
        } else {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This Product is not found!'),
                ],
                404
            );
        }
    }

    public function removeFromCart(Request $request)
    {
        $id          = $request->id;
        $session_key = $request->session_key;
        if (isset($id) && !empty($id) && isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put($session_key, $cart);
            }
            return redirect()->back()->with('success', __('Product removed from cart!'));
        } else {
            return redirect()->back()->with('error', __('This Product is not found!'));
        }
    }

    public function emptyCart(Request $request)
    {
        $session_key = $request->session_key;

        if (isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);
            if (isset($cart) && count($cart) > 0) {
                session()->forget($session_key);
            }

            return redirect()->back()->with('success', __('Cart is empty!'));
        } else {
            return redirect()->back()->with('error', __('Cart cannot be empty!.'));
        }
    }

    // public function productVariant(Request $request, $id, $session_key)
    // {
    //     $product = Product::where('id', $id)->first();
    //     $product_variant_names = ProductVariant::where('product_id', $product->id)->get();

    //     return view('pos.product_variant', compact('product', 'product_variant_names', 'session_key'));
    // }

    // public function getProductsVariantQuantity(Request $request)
    // {
    //     $status = false;
    //     $quantity = $variant_id = 0;
    //     $quantityHTML = '<strong>' . __('Please select variants to get available quantity.') . '</strong>';
    //     $priceHTML = '';
    //     $product = Product::find($request->product_id);
    //     $price = currency_format_with_sym($product->price, getCurrentStore(), APP_THEME());
    //     $status = false;

        

    //     return response()->json(
    //         [
    //             'status' => $status,
    //             'price' => $price,
    //             'quantity' => $quantity,
    //             'variant_id' => $variant_id
    //         ]
    //     );
    // }

    // public function VariantDelete(Request $request, $id, $product_id)
    // {
    //     if (auth()->user() && auth()->user()->can('Delete Variants')) {
    //         $product = Product::find($product_id);
    //         if (!empty($product->variants_json) && ProductVariantOption::find($id)->exists()) {
    //             $var_json = json_decode($product->variants_json, true);

    //             $i = 0;
    //             foreach ($var_json[0] as $key => $value) {
    //                 $var_ops = explode(' : ', ProductVariantOption::find($id)->name);
    //                 $count = ProductVariantOption::where('product_id', $product->id)->where('name', 'LIKE', '%' . $var_ops[0] . '%')->count();
    //                 if ($count == 1 && $i == 0) {
    //                     $unsetIndex = array_search($var_ops[0], $var_json[0]['variant_options'], true);
    //                     unset($var_json[0]['variant_options'][$unsetIndex]);
    //                 }
    //                 $i++;
    //             }
    //             $variants = ProductVariantOption::where('product_id', $product->id)->count();
    //             if ($variants == 1) {
    //                 $product->variants_json = '{}';
    //                 $product->update();
    //             } else {
    //                 $product->variants_json = json_encode($var_json);
    //                 $product->update();
    //             }
    //         }
    //         ProductVariantOption::find($id)->delete();
    //         return redirect()->back()->with('success', __('Variant successfully deleted.'));
    //     } else {
    //         return redirect()->back()->with('error', 'Permission denied.');
    //     }
    // }
}
