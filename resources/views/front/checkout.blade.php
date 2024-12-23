@extends('front.layout')
@section('content')
<!-- Product Start -->
<div class="container-xxl py-5 mt-5">
    <div class="container">
        <h2>Checkout</h2>
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
        <form  method="post">
            @csrf
            <!-- Personal Information Section -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Personal Details</h5>

                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                </div>
            </div>

            <!-- Shipping Address Section -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Shipping Address</h5>

                    <div class="mb-3">
                        <label for="address" class="form-label">Street Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>

                    <div class="mb-3">
                        <label for="city_name" class="form-label">City</label>
                        <input type="text" class="form-control" id="city_name" name="city_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="postcode" class="form-label">Postal Code</label>
                        <input type="text" class="form-control" id="postcode" name="postcode" required>
                    </div>

                    <div class="mb-3">
                        <label for="country_name" class="form-label">Country</label>
                        <select class="form-select" id="country_name" name="country_name" required>
                            <option value="Pakistan">Pakistan</option>
                            
                        </select>
                    </div>
                </div>
            </div>

            <!-- Payment Method Section -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Payment Method</h5>

                    <div class="mb-3">
                        <label for="paymtd" class="form-label">Cardholder Name</label>
                        <select class="form-select" id="paymtd" name="paymtd" required>
                            <option value="cod">Cash on Delivery</option>
                            
                        </select>
                    </div>

                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Place Order</button>
            </div>
        </form>

    </div>
</div>
<!-- Product End -->

@endsection