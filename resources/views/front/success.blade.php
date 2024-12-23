@extends('front.layout')
@section('content')
<!-- Product Start -->
<div class="container-xxl py-5 mt-5">
    <div class="container mt-5 text-center">
        <!-- Thank You Message -->
        <div class="alert alert-success">
            <h2>Your Order Has Been Placed!</h2>
            <p class="lead">Thank you for shopping with us. Your order has been successfully placed.</p>
            <!-- <p>Order ID: <strong>#123456789</strong></p> -->
            <p>We will send you an email confirmation shortly with the details of your order.</p>
        </div>

        <!-- Continue Shopping Button -->
        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Continue Shopping</a>
    </div>
</div>
<!-- Product End -->

@endsection