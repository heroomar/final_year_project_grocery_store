@extends('front.layout')
@section('content')



    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="about-img position-relative overflow-hidden p-5 pe-0">
                        <img class="img-fluid w-100" src="{{ url('front/img/about.jpg') }}">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-5 mb-4">About Us</h1>
                    <p class="mb-4">GrocerApp has been offering highest quality groceries and home essential items since 2016. With our efficient model online grocery shopping and convenient home delivery, we can proudly say that we have pioneered online grocery shopping. Our intuitive, simple solutions for retailers customers, brands and shoppers are transforming how every Pakistan shops, eats and lives.</p>
                    <!-- <a class="btn btn-primary rounded-pill py-3 px-5 mt-3" href="">Read More</a> -->
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    


    <!-- Feature Start -->
    <div class="container-fluid bg-light bg-icon my-5 py-6">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-5 mb-3">Our Categories</h1>
                <p>Here are our top three Categories.</p>
            </div>
            <?php
            // array_rand($array, 3);
            $subcat = \App\Models\SubCategory::get()->toArray();
            $_subcat = array_rand($subcat,3);
            
            ?>
            <div class="row g-4">
                @foreach($_subcat as $i)
                <?php
                $cat = $subcat[$i]; 
                $imagePath = get_file($cat['image_path'], APP_THEME());
                ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-white text-center h-100 p-4 p-xl-5">
                        <img class="img-fluid mb-4" src="{{ $imagePath }}" alt="">
                        <h4 class="mb-3">{{ $cat['name'] }}</h4>
                        <!-- <p class="mb-4">Tempor ut dolore lorem kasd vero ipsum sit eirmod sit. Ipsum diam justo sed vero dolor duo.</p> -->
                        <a class="btn btn-outline-primary border-2 py-2 px-4 rounded-pill" href="{{ url('/products?category=&subcategory='.$cat['id'].'&search=') }}">Browse Products</a>
                    </div>
                </div>
                @endforeach
                
                
            </div>
        </div>
    </div>
    <!-- Feature End -->


    @endsection