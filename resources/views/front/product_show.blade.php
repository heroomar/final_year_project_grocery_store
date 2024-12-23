@extends('front.layout')
@section('content')
<!-- Product Start -->
<div class="container-xxl py-5 mt-5">
    <div class="container">
        <!-- Product Image Slider -->
        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                if (isset($product->cover_image_path) && !empty($product->cover_image_path)) {
                    ?>
                    <div class="carousel-item active">
                        <img style="max-width: 400px;margin: auto;" src="{{ get_file($product->cover_image_path, APP_THEME()) }}" class="d-block w-100" alt="Product Image 1">
                    </div>
                    <?php
                }
                ?>
                @foreach ($product->Sub_image() as $i => $image)
                    
                    <div class="carousel-item ">
                        <img style="max-width: 400px;margin: auto;" src="{{ get_file($image->image_path, APP_THEME()) }}" class="d-block w-100" alt="Product Image 1">
                    </div>
                @endforeach
                
                
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Product Title -->
        <h2 class="mt-3">{{ $product->name }}</h2>

        <!-- Available Quantity -->
        <p class="mt-2">Available Quantity: <span>{{ $product->product_stock }}</span></p>

        <!-- Price -->
        <div class="d-flex align-items-center mt-2">
            <?php
            if ($product->sale_price > 0 && $product->price > $product->sale_price){?>
                    <h3 class="text-primary me-1">Rs. {{ $product->sale_price }}</h3>
                    <h4 class="text-body text-decoration-line-through">Rs. {{ $product->price }}</h4>
            <?php } else { ?>
                    <h4 class="text-primary me-1">Rs. {{ $product->price }}</h4>
                    
            <?php } ?>
        </div>

        <!-- Add to Cart Button -->
        <a href="{{ $product->addtocartlink() }}" class="btn btn-primary btn-lg w-100 mt-3">Add to Cart</a>

        <!-- Product Details Description -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Product Details</h5>
                {!! $product->description  !!}
            </div>
        </div>

    </div>
</div>
<!-- Product End -->

@endsection