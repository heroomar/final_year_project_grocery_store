@php
    $logo = asset(Storage::url('uploads/logo/'));
    $company_logo = '';
    $company_logo = ($company_logo);
@endphp
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>

<!-- [ Pre-loader ] End -->
<!-- [ navigation menu ] start -->
@if (isset($setting['cust_theme_bg']) && $setting['cust_theme_bg'] == 'on')
<nav class="dash-sidebar light-sidebar transprent-bg">
    @else
        <nav class="dash-sidebar light-sidebar">
@endif 
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('dashboard') }}" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
               <img src="{{ isset($company_logo) && !empty($company_logo) ? $company_logo . '?timestamp=' . time() : $logo . '/logo-dark.svg' . '?timestamp=' . time() }}"
                alt="" class="logo logo-lg" />
            </a>
        </div>

        <div class="navbar-content">
            <ul class="dash-navbar">
                <?php
                $sa=array (
                    0 => 
                    array (
                      'title' => 'CMS',
                      'icon' => 'package',
                      'name' => 'landing-page',
                      'parent' => NULL,
                      'order' => 220,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => '',
                      'module' => 'LandingPage',
                      'permission' => 'Manage CMS',
                    ),
                    1 => 
                    array (
                      'title' => 'Landing Page',
                      'icon' => 'settings',
                      'name' => '',
                      'parent' => 'landing-page',
                      'order' => 1,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'landingpage.index',
                      'module' => 'LandingPage',
                      'permission' => '',
                    ),
                    2 => 
                    array (
                      'title' => 'Menus',
                      'icon' => 'settings',
                      'name' => '',
                      'parent' => 'landing-page',
                      'order' => 3,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'ownermenus.index',
                      'module' => 'LandingPage',
                      'permission' => '',
                    ),
                    3 => 
                    array (
                      'title' => 'Custom Page',
                      'icon' => 'settings',
                      'name' => '',
                      'parent' => 'landing-page',
                      'order' => 4,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'menu-pages.index',
                      'module' => 'LandingPage',
                      'permission' => '',
                    ),
                    4 => 
                    array (
                      'title' => 'Dashboard',
                      'icon' => 'home',
                      'name' => 'dashboard',
                      'parent' => NULL,
                      'order' => 1,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'dashboard',
                      'module' => 'Base',
                      'permission' => 'Manage Dashboard',
                    ),
                    5 => 
                    array (
                      'title' => 'Add-on Manager',
                      'icon' => 'layout-2',
                      'name' => 'add-on-manager',
                      'parent' => NULL,
                      'order' => 60,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'module.index',
                      'module' => 'Base',
                      'permission' => '',
                    ),
                    6 => 
                    array (
                      'title' => 'Users',
                      'icon' => 'user',
                      'name' => 'users',
                      'parent' => NULL,
                      'order' => 80,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'stores.index',
                      'module' => 'Base',
                      'permission' => 'Manage User',
                    ),
                    7 => 
                    array (
                      'title' => 'Coupons',
                      'icon' => 'gift',
                      'name' => 'coupon',
                      'parent' => NULL,
                      'order' => 100,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'plan-coupon.index',
                      'module' => 'Base',
                      'permission' => 'Manage Coupon',
                    ),
                    8 => 
                    array (
                      'title' => 'Plan',
                      'icon' => 'trophy',
                      'name' => 'plan',
                      'parent' => NULL,
                      'order' => 120,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'plan.index',
                      'module' => 'Base',
                      'permission' => 'Manage Plan',
                    ),
                    9 => 
                    array (
                      'title' => 'Plan Request',
                      'icon' => 'arrow-up-right-circle',
                      'name' => 'planrequest',
                      'parent' => NULL,
                      'order' => 140,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'plan-request.index',
                      'module' => 'Base',
                      'permission' => 'Manage Plan Request',
                    ),
                    10 => 
                    array (
                      'title' => 'Settings',
                      'icon' => 'settings',
                      'name' => 'settings',
                      'parent' => NULL,
                      'order' => 300,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'setting.index',
                      'module' => 'Base',
                      'permission' => 'Manage Setting',
                    ),
                  );





                $com = array (
                    0 => 
                    array (
                      'title' => 'Dashboard',
                      'icon' => 'home',
                      'name' => 'admin_dashboard',
                      'parent' => NULL,
                      'order' => 1,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => '',
                      'module' => 'Base',
                      'permission' => 'Manage Dashboard',
                    ),
                    1 => 
                    array (
                      'title' => 'Dashboard',
                      'icon' => 'home',
                      'name' => 'dashboard',
                      'parent' => 'admin_dashboard',
                      'order' => 1,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'dashboard',
                      'module' => 'Base',
                      'permission' => 'Manage Dashboard',
                    ),
                    2 => 
                    array (
                      'title' => 'Store Analytics',
                      'icon' => '',
                      'name' => 'store-analytics',
                      'parent' => 'admin_dashboard',
                      'order' => 2,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'theme_analytic',
                      'module' => 'Base',
                      'permission' => 'Manage Store Analytics',
                    ),
                    3 => 
                    array (
                      'title' => 'Theme Preview',
                      'icon' => 'rotate',
                      'name' => 'themepreview',
                      'parent' => NULL,
                      'order' => 20,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'theme-preview.index',
                      'module' => 'Base',
                      'permission' => 'Manage Themes',
                    ),
                    4 => 
                    array (
                      'title' => 'Store Setting',
                      'icon' => 'settings-automation',
                      'name' => 'storesetting',
                      'parent' => NULL,
                      'order' => 40,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'app-setting.index',
                      'module' => 'Base',
                      'permission' => 'Manage Store Setting',
                    ),
                    5 => 
                    array (
                      'title' => 'Mobile App Settings',
                      'icon' => 'settings-automation',
                      'name' => 'mobilescreensetting',
                      'parent' => NULL,
                      'order' => 60,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'mobilescreen.content',
                      'module' => 'Base',
                      'permission' => '',
                    ),
                    6 => 
                    array (
                      'title' => 'Staff',
                      'icon' => 'users',
                      'name' => 'staff',
                      'parent' => NULL,
                      'order' => 80,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => '',
                      'module' => 'Base',
                      'permission' => 'Manage User',
                    ),
                    7 => 
                    array (
                      'title' => 'Roles',
                      'icon' => '',
                      'name' => 'roles',
                      'parent' => 'staff',
                      'order' => 1,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'roles.index',
                      'module' => 'Base',
                      'permission' => 'Manage Role',
                    ),
                    8 => 
                    array (
                      'title' => 'User',
                      'icon' => '',
                      'name' => 'user',
                      'parent' => 'staff',
                      'order' => 2,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'users.index',
                      'module' => 'Base',
                      'permission' => 'Manage User',
                    ),
                    9 => 
                    array (
                      'title' => 'Delivery Boy',
                      'icon' => 'truck',
                      'name' => 'deliveryboy',
                      'parent' => NULL,
                      'order' => 100,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'deliveryboy.index',
                      'module' => 'Base',
                      'permission' => 'Manage Deliveryboy',
                    ),
                    10 => 
                    array (
                      'title' => 'Products',
                      'icon' => 'shopping-cart',
                      'name' => 'products',
                      'parent' => NULL,
                      'order' => 120,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => '',
                      'module' => 'Base',
                      'permission' => 'Manage Products',
                    ),
                    // 11 => 
                    // array (
                    //   'title' => 'Brand',
                    //   'icon' => 'home',
                    //   'name' => 'productBrand',
                    //   'parent' => 'products',
                    //   'order' => 1,
                    //   'ignore_if' => 
                    //   array (
                    //   ),
                    //   'depend_on' => 
                    //   array (
                    //   ),
                    //   'route' => 'product-brand.index',
                    //   'module' => 'Base',
                    //   'permission' => 'Manage Product Brand',
                    // ),
                    // 12 => 
                    // array (
                    //   'title' => 'Label',
                    //   'icon' => 'home',
                    //   'name' => 'productLabel',
                    //   'parent' => 'products',
                    //   'order' => 2,
                    //   'ignore_if' => 
                    //   array (
                    //   ),
                    //   'depend_on' => 
                    //   array (
                    //   ),
                    //   'route' => 'product-label.index',
                    //   'module' => 'Base',
                    //   'permission' => 'Manage Product Label',
                    // ),
                    13 => 
                    array (
                      'title' => 'Main Category',
                      'icon' => 'home',
                      'name' => 'maincategory',
                      'parent' => 'products',
                      'order' => 3,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'main-category',
                      'module' => 'Base',
                      'permission' => 'Manage Product Category',
                    ),
                    14 => 
                    array (
                      'title' => 'Sub Category',
                      'icon' => 'home',
                      'name' => 'subcategory',
                      'parent' => 'products',
                      'order' => 4,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'sub-category',
                      'module' => 'Base',
                      'permission' => 'Manage Product Sub Category',
                    ),
                    15 => 
                    array (
                      'title' => 'Product',
                      'icon' => 'home',
                      'name' => 'product',
                      'parent' => 'products',
                      'order' => 5,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'product.index',
                      'module' => 'Base',
                      'permission' => 'Manage Products',
                    ),
                    // 16 => 
                    // array (
                    //   'title' => 'Attributes',
                    //   'icon' => 'home',
                    //   'name' => 'attributes',
                    //   'parent' => 'products',
                    //   'order' => 6,
                    //   'ignore_if' => 
                    //   array (
                    //   ),
                    //   'depend_on' => 
                    //   array (
                    //   ),
                    //   'route' => 'product-attributes.index',
                    //   'module' => 'Base',
                    //   'permission' => 'Manage Attributes',
                    // ),
                    // 17 => 
                    // array (
                    //   'title' => 'Testimonial',
                    //   'icon' => 'home',
                    //   'name' => 'Testimonial',
                    //   'parent' => 'products',
                    //   'order' => 8,
                    //   'ignore_if' => 
                    //   array (
                    //   ),
                    //   'depend_on' => 
                    //   array (
                    //   ),
                    //   'route' => 'testimonial.index',
                    //   'module' => 'Base',
                    //   'permission' => 'Manage Testimonial',
                    // ),
                    // 18 => 
                    // array (
                    //   'title' => 'Question Answer',
                    //   'icon' => 'home',
                    //   'name' => 'question_answer',
                    //   'parent' => 'products',
                    //   'order' => 9,
                    //   'ignore_if' => 
                    //   array (
                    //   ),
                    //   'depend_on' => 
                    //   array (
                    //   ),
                    //   'route' => 'product-question.index',
                    //   'module' => 'Base',
                    //   'permission' => 'Manage Product Question',
                    // ),
                    19 => 
                    array (
                      'title' => 'Shipping',
                      'icon' => 'truck-delivery',
                      'name' => 'shipping',
                      'parent' => NULL,
                      'order' => 140,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => '',
                      'module' => 'Base',
                      'permission' => 'Manage Shipping',
                    ),
                    20 => 
                    array (
                      'title' => 'Shipping Class',
                      'icon' => '',
                      'name' => 'shipping class',
                      'parent' => 'shipping',
                      'order' => 34,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'shipping.index',
                      'module' => 'Base',
                      'permission' => 'Manage Shipping Class',
                    ),
                    21 => 
                    array (
                      'title' => 'Shipping Zone',
                      'icon' => '',
                      'name' => 'shipping zone',
                      'parent' => 'shipping',
                      'order' => 35,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'shipping-zone.index',
                      'module' => 'Base',
                      'permission' => 'Manage Shipping Zone',
                    ),
                    22 => 
                    array (
                      'title' => 'Orders',
                      'icon' => 'briefcase',
                      'name' => 'orders',
                      'parent' => NULL,
                      'order' => 160,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'order.index',
                      'module' => 'Base',
                      'permission' => 'Manage Order',
                    ),
                    // 23 => 
                    // array (
                    //   'title' => 'Orders',
                    //   'icon' => 'user',
                    //   'name' => 'order',
                    //   'parent' => 'orders',
                    //   'order' => 1,
                    //   'ignore_if' => 
                    //   array (
                    //   ),
                    //   'depend_on' => 
                    //   array (
                    //   ),
                    //   'route' => 'order.index',
                    //   'module' => 'Base',
                    //   'permission' => 'Manage Order',
                    // ),
                    // 24 => 
                    // array (
                    //   'title' => 'Order Refund Request',
                    //   'icon' => 'user',
                    //   'name' => 'order-refund-request',
                    //   'parent' => 'orders',
                    //   'order' => 2,
                    //   'ignore_if' => 
                    //   array (
                    //   ),
                    //   'depend_on' => 
                    //   array (
                    //   ),
                    //   'route' => 'refund-request.index',
                    //   'module' => 'Base',
                    //   'permission' => 'Manage Order Refund Request',
                    // ),
                    25 => 
                    array (
                      'title' => 'Customers',
                      'icon' => 'user',
                      'name' => 'customers',
                      'parent' => NULL,
                      'order' => 180,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'customer.index',
                      'module' => 'Base',
                      'permission' => 'Manage Customer',
                    ),
                    26 => 
                    array (
                      'title' => 'Reports',
                      'icon' => 'chart-bar',
                      'name' => 'reports',
                      'parent' => NULL,
                      'order' => 200,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => '',
                      'module' => 'Base',
                      'permission' => 'Manage Reports',
                    ),
                    27 => 
                    array (
                      'title' => 'Customer Reports',
                      'icon' => 'home',
                      'name' => '',
                      'parent' => 'reports',
                      'order' => 1,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'reports.index',
                      'module' => 'Base',
                      'permission' => 'Manage Reports',
                    ),
                    28 => 
                    array (
                      'title' => 'Order Reports',
                      'icon' => 'home',
                      'name' => 'order_reports',
                      'parent' => 'reports',
                      'order' => 2,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => '',
                      'module' => 'Base',
                      'permission' => 'Manage Order Reports',
                    ),
                    29 => 
                    array (
                      'title' => 'Sales Report',
                      'icon' => 'home',
                      'name' => '',
                      'parent' => 'order_reports',
                      'order' => 1,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'reports.order_report',
                      'module' => 'Base',
                      'permission' => '',
                    ),
                    30 => 
                    array (
                      'title' => 'Sales Product Report',
                      'icon' => 'home',
                      'name' => '',
                      'parent' => 'order_reports',
                      'order' => 2,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'reports.order_product_report',
                      'module' => 'Base',
                      'permission' => '',
                    ),
                    31 => 
                    array (
                      'title' => 'Sales Category Report',
                      'icon' => 'home',
                      'name' => '',
                      'parent' => 'order_reports',
                      'order' => 3,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'reports.order_category_report',
                      'module' => 'Base',
                      'permission' => '',
                    ),
                    32 => 
                    array (
                      'title' => 'Sales Downloadable Product',
                      'icon' => 'home',
                      'name' => '',
                      'parent' => 'order_reports',
                      'order' => 4,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'reports.order_downloadable_report',
                      'module' => 'Base',
                      'permission' => '',
                    ),
                    33 => 
                    array (
                      'title' => 'Sales Brand Report',
                      'icon' => 'home',
                      'name' => '',
                      'parent' => 'order_reports',
                      'order' => 5,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'reports.order_brand_report',
                      'module' => 'Base',
                      'permission' => '',
                    ),
                    34 => 
                    array (
                      'title' => 'Country Based Order Report',
                      'icon' => 'home',
                      'name' => '',
                      'parent' => 'order_reports',
                      'order' => 6,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'reports.orderCountryReport',
                      'module' => 'Base',
                      'permission' => '',
                    ),
                    35 => 
                    array (
                      'title' => 'Top Sales Reports',
                      'icon' => 'home',
                      'name' => '',
                      'parent' => 'reports',
                      'order' => 3,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'reports.top_product',
                      'module' => 'Base',
                      'permission' => '',
                    ),
                    36 => 
                    array (
                      'title' => 'Order Status Reports',
                      'icon' => 'home',
                      'name' => '',
                      'parent' => 'order_reports',
                      'order' => 7,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'reports.orderStatusReport',
                      'module' => 'Base',
                      'permission' => '',
                    ),
                    37 => 
                    array (
                      'title' => 'Stock Reports',
                      'icon' => 'home',
                      'name' => '',
                      'parent' => 'reports',
                      'order' => 4,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'reports.stock_report',
                      'module' => 'Base',
                      'permission' => 'Manage Stock Reports',
                    ),
                    38 => 
                    array (
                      'title' => 'Marketing',
                      'icon' => 'confetti',
                      'name' => 'marketing',
                      'parent' => NULL,
                      'order' => 220,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => '',
                      'module' => 'Base',
                      'permission' => 'Manage Marketing',
                    ),
                    39 => 
                    array (
                      'title' => 'Coupon',
                      'icon' => 'home',
                      'name' => 'coupon',
                      'parent' => 'marketing',
                      'order' => 1,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'coupon.index',
                      'module' => 'Base',
                      'permission' => 'Manage Coupon',
                    ),
                    40 => 
                    array (
                      'title' => 'Newsletter',
                      'icon' => 'home',
                      'name' => 'newsletter',
                      'parent' => 'marketing',
                      'order' => 2,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'newsletter.index',
                      'module' => 'Base',
                      'permission' => 'Manage Newsletter',
                    ),
                    41 => 
                    array (
                      'title' => 'Flash Sale',
                      'icon' => 'home',
                      'name' => 'flashsale',
                      'parent' => 'marketing',
                      'order' => 3,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'flash-sale.index',
                      'module' => 'Base',
                      'permission' => 'Manage Flash Sale',
                    ),
                    42 => 
                    array (
                      'title' => 'Wishlist',
                      'icon' => 'home',
                      'name' => 'wishlist',
                      'parent' => 'marketing',
                      'order' => 4,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'wishlist.index',
                      'module' => 'Base',
                      'permission' => 'Manage Wishlist',
                    ),
                    43 => 
                    array (
                      'title' => 'Abandon Cart',
                      'icon' => 'home',
                      'name' => 'abandon_cart',
                      'parent' => 'marketing',
                      'order' => 5,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'abandon.carts.handled',
                      'module' => 'Base',
                      'permission' => 'Manage Cart',
                    ),
                    44 => 
                    array (
                      'title' => 'Support Ticket',
                      'icon' => 'ticket',
                      'name' => 'support_ticket.index',
                      'parent' => NULL,
                      'order' => 280,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'support_ticket.index',
                      'module' => 'Base',
                      'permission' => 'Manage Support Ticket',
                    ),
                    45 => 
                    array (
                      'title' => 'POS',
                      'icon' => 'layers-difference',
                      'name' => 'pos',
                      'parent' => NULL,
                      'order' => 300,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'pos.index',
                      'module' => 'Base',
                      'permission' => 'Manage Pos',
                    ),
                    46 => 
                    array (
                      'title' => 'CMS',
                      'icon' => 'layout-cards',
                      'name' => 'cms',
                      'parent' => NULL,
                      'order' => 320,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => '',
                      'module' => 'Base',
                      'permission' => 'Manage CMS',
                    ),
                    47 => 
                    array (
                      'title' => 'Menu',
                      'icon' => 'home',
                      'name' => 'menu',
                      'parent' => 'cms',
                      'order' => 1,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'menus.index',
                      'module' => 'Base',
                      'permission' => 'Manage Menu',
                    ),
                    48 => 
                    array (
                      'title' => 'Pages',
                      'icon' => 'home',
                      'name' => 'pages',
                      'parent' => 'cms',
                      'order' => 2,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'pages.index',
                      'module' => 'Base',
                      'permission' => 'Manage Page',
                    ),
                    49 => 
                    array (
                      'title' => 'Blog Section',
                      'icon' => 'home',
                      'name' => 'blog_section',
                      'parent' => 'cms',
                      'order' => 3,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => '',
                      'module' => 'Base',
                      'permission' => 'Manage Blog',
                    ),
                    50 => 
                    array (
                      'title' => 'Blog',
                      'icon' => '',
                      'name' => 'blog',
                      'parent' => 'blog_section',
                      'order' => 1,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'blog.index',
                      'module' => 'Base',
                      'permission' => 'Manage Blog',
                    ),
                    51 => 
                    array (
                      'title' => 'Blog Category',
                      'icon' => '',
                      'name' => 'blog-category',
                      'parent' => 'blog_section',
                      'order' => 2,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'blog-category.index',
                      'module' => 'Base',
                      'permission' => 'Manage Blog Category',
                    ),
                    52 => 
                    array (
                      'title' => 'Faqs',
                      'icon' => 'home',
                      'name' => 'faq',
                      'parent' => 'cms',
                      'order' => 4,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'faqs.index',
                      'module' => 'Base',
                      'permission' => 'Manage Faqs',
                    ),
                    53 => 
                    array (
                      'title' => 'Tag',
                      'icon' => 'home',
                      'name' => 'tag',
                      'parent' => 'cms',
                      'order' => 5,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'tag.index',
                      'module' => 'Base',
                      'permission' => 'Manage Tag',
                    ),
                    54 => 
                    array (
                      'title' => 'Contact Us',
                      'icon' => 'home',
                      'name' => 'contact-us',
                      'parent' => 'cms',
                      'order' => 6,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'contacts.index',
                      'module' => 'Base',
                      'permission' => 'Manage Contact Us',
                    ),
                    55 => 
                    array (
                      'title' => 'Plan',
                      'icon' => 'trophy',
                      'name' => 'plan',
                      'parent' => NULL,
                      'order' => 340,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'plan.index',
                      'module' => 'Base',
                      'permission' => 'Manage Plan',
                    ),
                    56 => 
                    array (
                      'title' => 'Settings',
                      'icon' => 'settings',
                      'name' => 'settings',
                      'parent' => NULL,
                      'order' => 360,
                      'ignore_if' => 
                      array (
                      ),
                      'depend_on' => 
                      array (
                      ),
                      'route' => 'setting.index',
                      'module' => 'Base',
                      'permission' => 'Manage Setting',
                    ),
                  );
                $user = auth()->user();
                
                
                // $menu = array_merge($sa,$com);
                $menu = $com;
                // dd($menu);
                echo generateMenu($menu, null) ;
                // getMenu()
                ?>
                
            </ul>
        </div>
</nav>
<!-- [ navigation menu ] end -->
