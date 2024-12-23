@extends('front.layout')
@section('content')
<!-- Product Start -->
<div class="container-xxl py-5 mt-5">
    <div class="container">
        <!-- Cart Summary Section -->
         <?php
            $total = 0;
            $_total = 0;
            
            foreach ($cart as $product){
                    
                     if ($product['sale_price'] > 0 && $product['price'] > $product['sale_price']){
                        $total +=  $product['qty'] * $product['sale_price'];
                     } else {
                        $total +=  $product['qty'] * $product['price'];
                        
                     }
                     $_total +=  $product['qty'] * $product['price'];
                    }
         ?>
        <div class="table-responsive mb-4">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td><h3>My Cart</h3></td>
                        <td class="text-end"></td>
                    </tr>
                    <tr>
                        <td><h5>Sub Total</h5></td>
                        <td class="text-end">Rs. {{ number_format($total,2) }}</td>
                    </tr>
                    <tr>
                        <td><h5>Delivery Charges</h5></td>
                        <td class="text-end">Free</td>
                    </tr>
                    <tr>
                        <td><h4>Coupon</h4></td>
                        <td class="text-end">
                            <form>
                                <input class="form-control" name="coupon" value="{{ $cart_extra['coupon']['coupon_code'] ?? '' }}" style="max-width: 200px;float: inline-end;" />
                                <button class="btn btn-primary"  >Apply</button>
                            </form>
                        </td>
                    </tr>
                    @if (($cart_extra['discount'] ?? 0) > 0)
                    <tr>
                        <td><h4>Discount</h4></td>
                        <td class="text-end">Rs. {{ number_format($cart_extra['discount'] ?? 0,2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><h4>Total Bill</h4></td>
                        <td class="text-end">Rs. {{ number_format(($total-($cart_extra['discount'] ?? 0)),2) }}</td>
                    </tr>
                    <tr>
                        <td><h5>Your Total Savings</h5></td>
                        <td class="text-end">Rs. {{ number_format(($_total-$total),2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Item List in a Card -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Items</h5>
                @foreach ($cart as $product)
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <?php
                            if (isset($product['cover_image_path']) && !empty($product['cover_image_path'])) {
                                echo '<img class="img-fluid" src="' . get_file($product['cover_image_path'], APP_THEME()) . '" alt="" >';
                            }
                            ?>
                            
                        </div>
                        <div class="col-md-6">
                            <h6>{{ $product['name'] }}</h6>
                            <p>Quantity: {{ $product['qty'] }}</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <a class="btn-sm-square bg-white rounded-circle ms-3" style="float: inline-end;color: red;" href="{{ url('/deletecart?id='.$product['id']) }}">
                                <small class="fa fa-trash text-body"></small>
                            </a>
                            <h6>Rs. <?php
                             if ($product['sale_price'] > 0 && $product['price'] > $product['sale_price']){
                                echo $product['sale_price'];
                             } else {
                                echo $product['price'];
                             }
                            ?></h6>
                        </div>
                    </div>
                @endforeach
                
                
            </div>
        </div>

        <!-- Checkout Button -->
         @if (count($cart) > 0)
         <a href="{{ url('/checkout') }}" class="btn btn-primary btn-lg w-100 mt-4">Proceed to Checkout</a>
         @endif
        

    </div>
</div>
<!-- Product End -->

@endsection