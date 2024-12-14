
@extends('layouts.app')

@section('page-title')
    {{ __('Orders') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">{{__('Customer')}}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Orders') }}</li>
@endsection
@section('action-button')
<div class="text-end">
    <a href="javascript:;" class="btn btn-sm btn-primary btn-icon csv" title="{{__('Export')}}" data-bs-toggle="tooltip" data-bs-placement="top">
        <i class="ti ti-file-export"></i>
    </a>
</div>
@endsection

@section('filter')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 dataTable" id="pc-dt-export">
                            <thead>
                                <tr>
                                    <th>{{ __('Orders') }}</th>
                                    <th>{{ __('Date') }}</th>
                                   
                                    <th>{{ __('Value') }}</th>
                                    <th>{{ __('Payment Type') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="ignore">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <th scope="row">
                                            <a href="{{ route('order.view', ($order->id)) }}"
                                                @php
                                                    $btn_class = 'bg-info';
                                                    if($order->delivered_status == 2 || $order->delivered_status == 3) {
                                                        $btn_class = 'bg-danger';
                                                    } elseif($order->delivered_status == 1) {
                                                        $btn_class = 'bg-success';
                                                    }elseif($order->delivered_status == 4) {
                                                        $btn_class = ' btn-warning';
                                                    } elseif($order->delivered_status == 5) {
                                                        $btn_class = 'btn-secondary';
                                                    } elseif($order->delivered_status == 6) {
                                                        $btn_class = 'btn-dark';
                                                    }
                                                @endphp
                                                class="btn {{ $btn_class }}  text-white btn-sm text-sm"
                                                data-toggle="tooltip" title="{{ __('Invoice ID') }}">
                                                <span class="btn-inner--text">#{{ $order->product_order_id }}</span>
                                            </a>
                                        </th>
                                        <td class="order">
                                            <span
                                                class="h6 text-sm font-weight-bold mb-0">{{ \App\Models\Utility::dateFormat($order->created_at) }}</span>
                                        </td>
                                        
                                        <td>
                                            <span>{{ currency_format_with_sym( ($order->final_price ?? 0), getCurrentStore(), APP_THEME()) ?? SetNumberFormat($order->final_price) }}</span>
                                        </td>
                                        <td>
                                            @if ($order->payment_type == 'cod')
                                                {{ __('Cash On Delivery') }}
                                            @elseif ($order->payment_type == 'bank_transfer')
                                                {{ __('Bank Transfer') }}
                                            @elseif ($order->payment_type == 'stripe')
                                                {{ __('Stripe')}}
                                            @elseif ($order->payment_type == 'paystack')
                                                {{ __('Paystack')}}
                                            @elseif ($order->payment_type == 'Mercado')
                                                {{ __('Mercado Pago')}}
                                            @elseif ($order->payment_type == 'skrill')
                                                {{ __('Skrill')}}
                                            @elseif ($order->payment_type == 'paymentwall')
                                                {{ __('PaymentWall')}}
                                            @elseif ($order->payment_type == 'Razorpay')
                                                {{ __('Razorpay')}}
                                            @elseif ($order->payment_type == 'paypal')
                                                {{ __('Paypal')}}
                                            @elseif ($order->payment_type == 'flutterwave')
                                                {{ __('Flutterwave')}}
                                            @elseif ($order->payment_type == 'mollie')
                                                {{ __('Mollie')}}
                                            @elseif ($order->payment_type == 'coingate')
                                                {{ __('Coingate')}}
                                            @elseif ($order->payment_type == 'paytm')
                                                {{ __('Paytm')}}
                                            @elseif ($order->payment_type == 'SenagePay')
                                                {{ __('SenagePay')}}
                                            @elseif ($order->payment_type == 'CyberSource')
                                                {{ __('CyberSource')}}
                                            @elseif ($order->payment_type == 'Ozow')
                                                {{ __('Ozow')}}
                                            @elseif ($order->payment_type == 'MyFatoorah')
                                                {{ __('MyFatoorah')}}
                                            @elseif ($order->payment_type == 'easebuzz')
                                                {{ __('Easebuzz')}}
                                            @elseif ($order->payment_type == 'payu')
                                                {{ __('PayU') }}
                                            @elseif ($order->payment_type == 'NMI')
                                            {{ __('NMI')}}
                                            @elseif ($order->payment_type == 'sofort')
                                            {{ __('Sofort')}}
                                            @elseif ($order->payment_type == 'Paynow')
                                                {{ __('Paynow')}}
                                            @elseif ($order->payment_type == 'esewa')
                                            {{ __('Esewa')}}
                                            @elseif ($order->payment_type == 'DPO')
                                            {{ __('DPO')}}
                                            @elseif ($order->payment_type == 'Braintree')
                                            {{ __('Braintree') }}
                                            @elseif ($order->payment_type == 'PowerTranz')
                                            {{ __('PowerTranz') }}
                                            @elseif ($order->payment_type == 'SSLCommerz')
                                            {{ __('SSLCommerz') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($order->delivered_status == 0)
                                                <button type="button"
                                                    class="btn btn-sm btn-info btn-icon rounded-pill badge-same">
                                                    <span class="btn-inner--icon">
                                                        <i class="fas fa-check soft-info"></i>
                                                    </span>
                                                    <span class="btn-inner--text"> {{ __('Pending') }} : {{ \App\Models\Utility::dateFormat($order->order_date) }} </span>
                                                </button>
                                            @elseif ($order->delivered_status == 1)
                                                <button type="button"
                                                    class="btn btn-sm btn-success btn-icon rounded-pill badge-same">
                                                    <span class="btn-inner--icon">
                                                        <i class="fas fa-check soft-success"></i>
                                                    </span>
                                                    <span class="btn-inner--text"> {{ __('Delivered') }} : {{ \App\Models\Utility::dateFormat($order->delivery_date) }} </span>
                                                </button>
                                                @elseif ($order->delivered_status == 4)
                                                <button type="button"
                                                    class="btn btn-sm btn-warning btn-icon rounded-pill badge-same">
                                                    <span class="btn-inner--icon">
                                                        <i class="fas fa-check soft-warning"></i>
                                                    </span>
                                                    <span class="btn-inner--text"> {{ __('Confirmed') }} : {{ \App\Models\Utility::dateFormat($order->confirmed_date) }} </span>
                                                </button>
                                            @elseif ($order->delivered_status == 5)
                                                <button type="button"
                                                    class="btn btn-sm btn-secondary btn-icon rounded-pill badge-same">
                                                    <span class="btn-inner--icon">
                                                        <i class="fas fa-check soft-secondary"></i>
                                                    </span>
                                                    <span class="btn-inner--text"> {{ __('Picked Up') }} : {{ \App\Models\Utility::dateFormat($order->pickedup_date) }} </span>
                                                </button>
                                            @elseif ($order->delivered_status == 6)
                                                <button type="button"
                                                    class="btn btn-sm btn-soft-dark btn-icon rounded-pill badge-same">
                                                    <span class="btn-inner--icon">
                                                        <i class="fas fa-check soft-dark"></i>
                                                    </span>
                                                    <span class="btn-inner--text"> {{ __('Shipped') }} : {{ \App\Models\Utility::dateFormat($order->shipped_date) }} </span>
                                                </button>
                                            @elseif ($order->delivered_status == 2)
                                                <button type="button"
                                                    class="btn btn-sm bg-danger btn-icon rounded-pill badge-same">

                                                    <span class="btn-inner--text"> {{ __('Cancel') }} : {{ \App\Models\Utility::dateFormat($order->cancel_date) }} </span>
                                                </button>
                                            @elseif ($order->delivered_status == 3)
                                                <button type="button"
                                                    class="btn btn-sm bg-danger btn-icon rounded-pill badge-same">

                                                    <span class="btn-inner--text"> {{ __('Return') }} : {{ \App\Models\Utility::dateFormat($order->return_date) }} </span>
                                                </button>

                                            @endif
                                        </td>
                                        <td class="text-center ignore">
                                            <div class="d-flex">
                                                    <a href="{{ route('order.view', ($order->id)) }}" class="btn btn-sm btn-icon  btn-info me-2" data-toggle="tooltip" data-original-title="{{ __('View') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Show') }}" data-tooltip="View">
                                                        <i  class="ti ti-eye"></i>
                                                    </a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['order.destroy', $order->id], 'class' => 'd-inline']) !!}
                                                <button type="button" class="btn btn-sm btn-danger show_confirm" data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                                {!! Form::close() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-script')
    <script src="https://rawgit.com/unconditional/jquery-table2excel/master/src/jquery.table2excel.js"></script>
    <script>
        const d = new Date();
        let seconds = d.getSeconds();
        $('.csv').on('click', function() {
            $('.ignore').remove();
            $("#pc-dt-export").table2excel({
                filename: 'Order_' + seconds
            });
            window.location.reload();
        })
    </script>
@endpush
