@extends('layouts.app')

@section('page-title', __('Main Category'))

@section('action-button')
   @permission('Create Product Category')
    <div class=" text-end gap-2 d-flex all-button-box justify-content-md-end justify-content-center">
        
        <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="Add Main Category"
            data-url="{{ route('main-category.create') }}" data-bs-toggle="tooltip" title="{{ __('Add Main Category') }}">
            <i class="ti ti-plus"></i>
        </a>
    </div>
    @endpermission
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Main Category') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
        {!! $dataTable !!}
        </div>
    </div>
@endsection
