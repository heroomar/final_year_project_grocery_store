@extends('layouts.app')

@section('page-title', __('Store Expense'))

@section('action-button')
   
    <div class=" text-end gap-2 d-flex all-button-box justify-content-md-end justify-content-center">
        
        <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="Add Store Expense"
            data-url="{{ route('store-expenses.create') }}" data-bs-toggle="tooltip" title="{{ __('Add Store Expense') }}">
            <i class="ti ti-plus"></i>
        </a>
    </div>
    
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Store Expense') }}</li>
@endsection

@section('content')
    <div class="card" >
        <div class="card-body" >
        <div class="row" >
        <div class="col-md-3 col-12">
                <div class="yellow-box details-box">
                    <div class="stats-wrapper d-flex align-items-center h-100">
                        <div class="card-text">
                            <h2 class="h6 mb-2">{{ __('Sales') }}</h2>
                            <h3 class="mb-0">{{ number_format(\App\Models\Order::sum('product_price'),0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $accounts = \App\Models\StoreExpense::get()->groupBy('account');
            foreach ($accounts as $account => $data) {
            ?>
            <div class="col-md-3 col-12">
                <div class="yellow-box details-box">
                    <div class="stats-wrapper d-flex align-items-center h-100">
                        <div class="card-text">
                            <h2 class="h6 mb-2">{{ ucfirst($account) }}</h2>
                            <h3 class="mb-0">{{ number_format(\App\Models\StoreExpense::where('account',$account)->sum('amount'),0) }}</h3>
                        </div>
                        
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
        
        <x-datatable :dataTable="$dataTable" />
        </div>
    </div>
@endsection
