@extends('layouts.app')

@section('page-title')
    {{ __('Product') }}
@endsection
@php
    $logo = asset(Storage::url('uploads/profile/'));
    
@endphp
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">{{ __('Product') }}</li>
@endsection

@section('action-button')
    
    <div class="text-end gap-2 d-flex all-button-box justify-content-md-end justify-content-center">
        

        <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary" data-title="{{ __('Create New Product') }}"
            data-bs-toggle="tooltip" title="{{ __('Add New Product') }}">
            <i class="ti ti-plus"></i>
        </a>
    </div>
    
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <x-datatable :dataTable="$dataTable" />
        </div>
    </div>
@endsection
