@extends('front.layout')
@section('content')




<!-- Product Start -->
<div class="container-xxl py-5 mt-5">
    <div class="container">
    <div class="container-fluid bg-light bg-icon my-5 py-6">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-5 mb-3">Our Categories</h1>
                <p>Here are our top three Categories.</p>
            </div>
            <?php
            // array_rand($array, 3);
            $subcat = \App\Models\SubCategory::get()->toArray();
            // $_subcat = array_rand($subcat,count($subcat));
            
            ?>
            <div class="row g-4">
                @foreach($subcat as $i => $cat)
                <?php
                // $cat = $subcat[$i]; 
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
    </div>
</div>
<!-- Product End -->

@endsection