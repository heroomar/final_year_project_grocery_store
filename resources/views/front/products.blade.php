@extends('front.layout')
@section('content')




<!-- Product Start -->
<div class="container-xxl py-5 mt-5">
    <div class="container">
        <div class="row g-0 gx-5 align-items-end">
            <div class="col-lg-6">
                <div class="section-header text-start mb-5 wow fadeInUp" data-wow-delay="0.1s"
                    style="max-width: 500px;">
                    <h1 class="display-5 mb-3">Our Products</h1>
                    <p>Browse our top Quality Products.</p>
                </div>
            </div>
            <script>
                function getcat(val){
                    $.get('{{ route('getcats') }}',{id: val}).then(function(res){
                        let html = `<option value="" >Select</option>`;
                        for (cat in res){
                            html += `<option value="`+(res[cat].id)+`" >`+(res[cat].name)+`</option>`;
                        }
                        $('[name=subcategory]').html(html)
                    })
                }
            </script>
            <div class="card m-3" style="border-radius: 14px;" >
                <div class="card-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-3">
                                <div class="form-floating">
                                    <select class="form-control" onchange="getcat(this.value)" name="category" style="background: white;" >
                                        <option value="" >Select</option>
                                        @foreach ($categories as $category)
                                        <option {{ ($_GET['category'] ?? '') == $category->id ? 'selected' : '' }} value="{{ $category->id }}" >{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="name">Category</label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-floating">
                                    <select class="form-control" name="subcategory" style="background: white;" >
                                        <option value="" >Select</option>
                                        <?php
                                        $SubCats = \App\Models\SubCategory::where('maincategory_id', ($_GET['category'] ?? 0))->get();
                                        if ($SubCats){
                                            foreach ($SubCats as $category){ ?>
                                                <option {{ ($_GET['subcategory'] ?? '') == $category->id ? 'selected' : '' }} value="{{ $category->id }}" >{{ $category->name }}</option>';
                                      <?php }
                                        }
                                        ?>
                                    </select>
                                    <label for="email">Sub-Category</label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="search" value="<?= $_GET['search'] ?? '' ?>" placeholder="Search">
                                    <label for="subject">Search</label>
                                </div>
                            </div>

                            <div class="col-3">
                                <button class="btn btn-primary rounded-pill py-3 px-5" type="submit">Search
                                    </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane fade show p-0 active">
                <div class="row g-4">
                    @forelse ($products as $product)
                                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                            <div class="product-item">
                                                <div class="position-relative bg-light overflow-hidden">
                                                    <!-- <img class="img-fluid w-100" src="img/product-1.jpg" alt=""> -->
                                                    <?php
                        if (isset($product->cover_image_path) && !empty($product->cover_image_path)) {
                            echo '<img class="img-fluid w-100" src="' . get_file($product->cover_image_path, APP_THEME()) . '" alt="" >';
                        }
                                                        ?>
                                                </div>
                                                <div class="text-center p-4">
                                                    <a class="d-block h5 mb-2" href="{{ $product->link() }}">{{ $product->name }}</a>
                                                    <?php
                                                    if ($product->sale_price > 0 && $product->price > $product->sale_price){?>
                                                           <span class="text-primary me-1">Rs. {{ $product->sale_price }}</span>
                                                           <span class="text-body text-decoration-line-through">Rs. {{ $product->price }}</span>
                                                    <?php } else { ?>
                                                            <span class="text-primary me-1">Rs. {{ $product->price }}</span>
                                                            
                                                    <?php } ?>
                                                    
                                                </div>
                                                <div class="d-flex border-top">
                                                    <small class="w-50 text-center border-end py-2">
                                                        <a class="text-body" href="{{ $product->link() }}"><i class="fa fa-eye text-primary me-2"></i>View
                                                            detail</a>
                                                    </small>
                                                    <small class="w-50 text-center py-2">
                                                        <a class="text-body" href="{{ $product->addtocartlink() }}"><i class="fa fa-shopping-bag text-primary me-2"></i>Add
                                                            to cart</a>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                    @empty
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <h3>No Products Found!</h3>
                        </div>
                    @endforelse
                    {{ $products->links() }}
                    <!-- <div class="col-12 text-center">
                            <a class="btn btn-primary rounded-pill py-3 px-5" href="">Browse More Products</a>
                        </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product End -->

@endsection