@extends('layouts.app')

@section('page-title', __('Sub Category'))

@section('action-button')
    
    <div class=" text-end  gap-2 d-flex all-button-box justify-content-md-end justify-content-center">
        
        <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md"
            data-title="{{ __('Add Sub category') }}" data-url="{{ route('sub-category.create') }}" data-bs-toggle="tooltip"
            title="{{ __('Add Sub Category') }}">
            <i class="ti ti-plus"></i>
        </a>
    </div>
    
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Sub Category') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <x-datatable :dataTable="$dataTable" />
        </div>
    </div>
@endsection
