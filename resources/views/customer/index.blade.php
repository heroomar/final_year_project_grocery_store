@extends('layouts.app')

@section('page-title')
    {{ __('Customer') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">{{ __('Customer') }}</li>
@endsection

@section('action-button')
    <div class="text-end">
        <a href="{{ route('customer.create') }}" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="Add Customer"
            data-url="{{ route('customer.create') }}" data-bs-toggle="tooltip" title="{{ __('Add Customer') }}">
            <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="row">

        

        <div class="col-md-12">
            <x-datatable :dataTable="$dataTable" />
        </div>

    </div>
@endsection

@push('custom-script')
    <script type="text/javascript">
        $(document).ready(function() {

            
        })
    </script>
    <script src="{{ asset('js/jquery.table2excel.js') }}"></script>
    <script>
        const d = new Date();
        let seconds = d.getSeconds();
        $(document).on('click', '.csv', function() {
            $('.ignore').remove();
            $("#customer-table").table2excel({
                filename: "Customer_" + seconds
            });
            window.location.reload();
        })
    </script>

    <script>
        $(document).ready(function() {

            

            $('#frm_submit').on('submit', function(event) {
                event.preventDefault();
                applyFilter();
            });

            $('#apply-button').on('click', function(event) {
                event.preventDefault();
                applyFilter();
            });

            // Function to apply the filter
            
        });
    </script>
@endpush
