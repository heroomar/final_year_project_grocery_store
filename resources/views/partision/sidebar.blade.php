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
               <img src="{{ url('/storage/uploads/logo/logo-light.png') }}"
                alt="" class="logo logo-lg" />
            </a>
        </div>

        <div class="navbar-content">
            <ul class="dash-navbar">
                <?php
                
                $admin = array (
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
                      'route' => 'dashboard',
                      'module' => 'Base',
                      'permission' => 'Manage Dashboard',
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
                      'title' => 'Sales Report',
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
                      'route' => 'reports.order_report',
                      'module' => 'Base',
                      'permission' => 'Manage Reports',
                    ),
                    
                    38 => 
                    array (
                      'title' => 'Coupon',
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
                      'route' => 'coupon.index',
                      'module' => 'Base',
                      'permission' => 'Manage Marketing',
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
                      'title' => 'Employees',
                      'icon' => 'user',
                      'name' => 'plan',
                      'parent' => NULL,
                      'order' => 340,
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
                    57 => array(
                      
                        'title' => 'Store Expenses',
                        'icon' => 'layout-cards',
                        'name' => 'se',
                        'parent' => NULL,
                        'order' => 341,
                        'ignore_if' => 
                        array (
                        ),
                        'depend_on' => 
                        array (
                        ),
                        'route' => 'store-expenses.index',
                        'module' => 'Base',
                        'permission' => 'Manage Store Expenses',
                      
                    )
                  );



                  $employee = array (
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
                      'route' => 'dashboard',
                      'module' => 'Base',
                      'permission' => 'Manage Dashboard',
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
                      'title' => 'Sales Report',
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
                      'route' => 'reports.order_report',
                      'module' => 'Base',
                      'permission' => 'Manage Reports',
                    ),
                    
                    38 => 
                    array (
                      'title' => 'Coupon',
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
                      'route' => 'coupon.index',
                      'module' => 'Base',
                      'permission' => 'Manage Marketing',
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
                    
                    
                    
                    57 => array(
                      
                        'title' => 'Store Expenses',
                        'icon' => 'layout-cards',
                        'name' => 'se',
                        'parent' => NULL,
                        'order' => 341,
                        'ignore_if' => 
                        array (
                        ),
                        'depend_on' => 
                        array (
                        ),
                        'route' => 'store-expenses.index',
                        'module' => 'Base',
                        'permission' => 'Manage Store Expenses',
                      
                    )
                  );



                  $customer = array (
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
                      'route' => 'dashboard',
                      'module' => 'Base',
                      'permission' => 'Manage Dashboard',
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
                    
                  );
                  
                $user = auth()->user();
                // $menu = array_merge($sa,$com);
                // $menu = $com;
                // dd($menu);
                if (auth()->user()->role == 1){
                  echo generateMenu($admin, null);
                } elseif(auth()->user()->role == 2){
                  echo generateMenu($employee, null); 
                } else {
                  echo generateMenu($customer, null); 
                }
                
                // getMenu()
                ?>
                
            </ul>
        </div>
</nav>
<!-- [ navigation menu ] end -->
