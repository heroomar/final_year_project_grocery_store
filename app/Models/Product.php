<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MainCategory;
use App\Models\TaxOption;
use Illuminate\Support\Facades\Cache;
use DB;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        
    ];


    protected $appends = ["category_name","sub_category_name",  "final_price"];


    public function getCategoryNameAttribute()
    {
        return !empty($this->ProductData) ? $this->ProductData->name : '';
    }

    public function getSubCategoryNameAttribute()
    {
        return !empty($this->SubCategoryctData) ? $this->SubCategoryctData->name : '';
    }

    // public static function slugs($data)
    // {
    //     $slug = '';
    //     // Remove special characters
    //     $slug = preg_replace('/[^a-zA-Z0-9\s-]/', '', $data);
    //     // Replace multiple spaces with a single hyphen
    //     $slug = preg_replace('/\s+/', '-', trim($slug));
    //     // Convert to lowercase
    //     $slug = strtolower($slug);
    //     $table = with(new Product)->getTable();

    //     $allSlugs = self::getRelatedSlugs($table, $slug ,$id = 0);

    //     if (!$allSlugs->contains('slug', $slug)) {
    //         return $slug;
    //     }
    //     for ($i = 1; $i <= 100; $i++) {
    //         $newSlug = $slug . '-' . $i;
    //         if (!$allSlugs->contains('slug', $newSlug)) {
    //             return $newSlug;

    //         }
    //     }
    // }

    

    public function ProductData()
    {
        return $this->hasOne(MainCategory::class, 'id', 'maincategory_id');
    }

    

    public function SubCategoryctData()
    {
        return $this->hasOne(SubCategory::class, 'id', 'subcategory_id');
    }
    
    // public static function Sub_image($product_id = 0)
    // {
    //     $return['status'] = false;
    //     $return['data'] = [];
    //     $ProductImage = Cache::remember('product_image_' . $product_id, 3600, function () use ($product_id) {
    //         return ProductImage::where('product_id', $product_id)->get();
    //     });
    //     if ($ProductImage->isNotEmpty()) {
    //         $return['status'] = true;
    //         $return['data'] = $ProductImage;
    //     } else {
    //         $ProductImage = Product::select('id', 'store_id', 'theme_id', 'id as product_id', 'cover_image_path as image_path')->where('id', $product_id)->get();
    //         $return['status'] = true;
    //         $return['data'] = $ProductImage;
    //     }
    //     return $return;
    // }
    

    // public static function ProductPrice($theme, $slug, $productId,$variantId = 0,$price=0)
    // {
    //     $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
    //             return Store::where('slug',$slug)->first();
    //         });
    //     $storeId = getCurrenctStoreId($slug);
    //     $product = Cache::remember('product_' . $productId, 3600, function () use ($productId) {
    //         return Product::find($productId);
    //     });
    //     if(empty($price))
    //     {
    //         $price = $product->sale_price;
    //     }
    //     // $price = $product->sale_price;
    //     $tax = Cache::remember('taxes_' . $product->tax_id, 3600, function () use ($product) {
    //         return Tax::find($product->tax_id);
    //     });

    //     $taxmethod = Cache::remember('tax_option_' . $product->tax_id.'_'.$theme.'_'.$storeId, 3600, function () use ($product, $theme, $storeId) {
    //         return TaxMethod::where('tax_id',$product->tax_id)->where('theme_id', $theme)->where('store_id', $storeId)->orderBy('priority', 'asc')->first();
    //     });
    //     $tax_option = Cache::remember('tax_option_' . $store->slug.'_'.$store->theme_id, 3600, function () use ($store) {
    //         return TaxOption::where('store_id', $store->id)
    //         ->where('theme_id', $store->theme_id)
    //         ->pluck('value', 'name')->toArray();
    //     });
        
    //     date_default_timezone_set('Asia/Kolkata');
    //     $currentDateTime = \Carbon\Carbon::now()->toDateTimeString();
    //     $sale_product = Cache::remember("flash_sale_{$store->theme_id}_{$store->id}", 3600, function () use ($store) {
    //         return FlashSale::where('theme_id', $store->theme_id)
    //         ->where('store_id', $store->id)
    //         ->where('is_active', 1)
    //         ->get();
    //     });

    //     $latestSales = [];
    //     foreach ($sale_product as $flashsale) {
    //         $saleEnableArray = json_decode($flashsale->sale_product, true);
    //         $startDate = \Carbon\Carbon::parse($flashsale['start_date'] . ' ' . $flashsale['start_time']);
    //         $endDate = \Carbon\Carbon::parse($flashsale['end_date'] . ' ' . $flashsale['end_time']);

    //         if ($endDate < $startDate) {
    //             $endDate->addDay();
    //         }
    //         if ($currentDateTime >= $startDate && $currentDateTime <= $endDate) {
    //             if (is_array($saleEnableArray) && in_array($productId, $saleEnableArray)) {
    //                 $latestSales[$productId] = [
    //                     'discount_type' => $flashsale->discount_type,
    //                     'discount_amount' => $flashsale->discount_amount,
    //                 ];
    //             }
    //         }
    //     }
    //     if ($latestSales == null) {
    //         $latestSales[$productId] = [
    //             'discount_type' => null,
    //             'discount_amount' => 0,
    //         ];
    //     }
    //     foreach ($latestSales as $productId => $saleData) {

    //         if ($product->variant_product == 0) {
    //             if ($saleData['discount_type'] == 'flat') {
    //                 $price = $product->price - $saleData['discount_amount'];
    //             }
    //             if ($saleData['discount_type'] == 'percentage') {
    //                 $discount_price =  $product->price * $saleData['discount_amount'] / 100;
    //                 $price = $product->price - $discount_price;
    //             }
    //         } else {
    //             $product_variant_data = ProductVariant::where('product_id', $product->id)->where('id',$variantId)->first();

    //             if ($product_variant_data) {
    //                 if ($saleData['discount_type'] == 'flat') {
    //                     $price = $product_variant_data->price - $saleData['discount_amount'];
    //                 } elseif ($saleData['discount_type'] == 'percentage') {
    //                     $discount_price = $product_variant_data->price * $saleData['discount_amount'] / 100;
    //                     $price = $product_variant_data->price - $discount_price;
    //                 }else{
    //                     $price = $product_variant_data->price;
    //                 }
    //             }
    //         }
    //     }
    //     if($tax && count($tax->tax_methods()) > 0)
    //     {
    //         if(isset($tax_option['price_type']) && isset($tax_option['shop_price']) &&$tax_option['price_type'] == 'inclusive' && $tax_option['shop_price'] == 'including')
    //         {
    //         $tax_price = 0;
    //             if($product->variant_product == 0)
    //             {
    //                 // $tax_price = $taxmethod->tax_rate * $price / 100;
    //                 foreach ($tax->tax_methods() as $mkey => $method) {
    //                 $amount = $method->tax_rate * $price / 100;
    //                 $tax_price += $amount;
    //                 }
    //                 if($tax_option['round_tax'] == 1)
    //                 {
    //                     $include_price = $price + $tax_price;
    //                     $price = round($include_price);
    //                 }
    //                 else{
    //                     $price = $price + $tax_price;
    //                 }
    //             }else{
    //                 $variant_data = ProductVariant::where('id', $variantId)->first();
    //                 if($variant_data)
    //                 {
    //                     // $tax_price = $taxmethod->tax_rate * $variant_data->price / 100;
    //                     foreach ($tax->tax_methods() as $mkey => $method) {
    //                 	 $amount = $method->tax_rate * $variant_data->price / 100;
    //                 	 $tax_price += $amount;
    //                 	 }
    //                     if($tax_option['round_tax'] == 1)
    //                     {
    //                         $include_price = $variant_data->price + $tax_price;
    //                         $price = round($include_price);
    //                     }
    //                     else{
    //                         $price = $variant_data->price + $tax_price;
    //                     }
    //                 }
    //             }

    //         }else{
    //             if($product->variant_product == 0)
    //             {
    //                 $price = $price ;
    //             }else{
    //                 $variant_data = ProductVariant::where('id', $variantId)->first();
    //                 $price = $variant_data->price ?? ($price ?? 0);
    //             }
    //         }
    //     }else{
    //         $price = $price;
    //     }
    //     return $price;
    // }

    

    

    

    // // Calculate Product Inclusive amount
    

    // public function getOriginalPriceAttribute()
    // {
    //     $variantId = $this->getAttribute('variantId');
    //     $variantName = $this->getAttribute('variantName');
    //     $variant_data = ProductVariant::where('variant', $variantName)->where('product_id', $this->id)->first();

    //     $variant_id = !empty($variantId) ? $variantId : ($variant_data ? $variant_data->id : null);
    //     $price = $this->price;
    //     if ($this->variant_product == 1) {
    //         $ProductStock = ProductVariant::find($variant_id);
    //         $price = 0;
    //         if (!empty($ProductStock)) {
    //             if ($ProductStock->price == 0 && $ProductStock->variation_price == 0) {
    //                 $price = $this->price;
    //             } else {
    //                 $price = $ProductStock->variation_price;
    //             }
    //         }
    //     }
    //     return SetNumber($price);
    // }

    public function getFinalPriceAttribute()
    {
        
        return 999;
    }

    // public static function instruction_array($theme_id = null, $store_id = null)
    // {
    //     $return = [];
    //     if (!empty($theme_id)) {
    //         $path = base_path('themes/' . $theme_id . '/theme_json/homepage.json');
    //         $json = json_decode(file_get_contents($path), true);
    //         $setting_json = AppSetting::select('theme_json')
    //             ->where('theme_id', $theme_id)
    //             ->where('page_name', 'main')
    //             ->where('store_id', $store_id)
    //             ->first();
    //         if (!empty($setting_json)) {
    //             $json = json_decode($setting_json->theme_json, true);
    //         }
    //         foreach ($json as $key => $value) {
    //             if ($value['unique_section_slug'] == 'homepage-plant-instruction') {
    //                 if ($value['array_type'] == 'multi-inner-list') {
    //                     for ($i = 0; $i < $value['loop_number']; $i++) {
    //                         foreach ($value['inner-list'] as $key1 => $value1) {
    //                             // $img_path = '';
    //                             // $description = '';
    //                             if ($value1['field_slug'] == 'homepage-plant-instruction-image') {
    //                                 $img_path = $value1['field_default_text'];
    //                                 if (!empty($json[$key][$value1['field_slug']])) {
    //                                     if (!empty($json[$key][$value1['field_slug']][$i]['image'])) {
    //                                         $img_path = $json[$key][$value1['field_slug']][$i]['image'];
    //                                     }
    //                                 }
    //                             }
    //                             if ($value1['field_slug'] == 'homepage-plant-instruction-description') {
    //                                 $description = $value1['field_default_text'];
    //                                 $return[$i]['description'] = $value1['field_default_text'];
    //                                 if (!empty($json[$key][$value1['field_slug']])) {
    //                                 }
    //                             }
    //                         }
    //                         $return[$i]['img_path'] = $img_path;
    //                         $return[$i]['description'] = $description;
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     return $return;
    // }

    


    // public static function actionLinks($currentTheme, $slug, $product)
    // {
    //     return view('front_end.hooks.action_link', compact('product', 'currentTheme', 'slug'))->render();
    // }

    
    // public static function ProductcardButton($currentTheme, $slug, $product)
    // {
    //     return view('front_end.hooks.card_button', compact('product', 'currentTheme', 'slug'))->render();
    // }

    // public static function getProductPrice ($product, $store, $currentTheme) {
    //     $slug = $store->slug;
    //     return view('front_end.hooks.product_price', compact('product', 'currentTheme', 'store','slug'))->render();
    // }

}
