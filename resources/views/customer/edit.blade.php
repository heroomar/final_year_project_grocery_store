@extends('layouts.app')

@section('page-title')
    {{ __('Edit Customer') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">{{ __('Edit Customer') }}</li>
@endsection

@section('action-button')
    <div class="text-end">
        
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
        <div class="card" >
            <div class="card-body" >
            {{ Form::model($customer,['route' => ['customer.update',$customer->id], 'method' => 'put', 'enctype' => 'multipart/form-data']) }}

                <div class="row col-8">
                    <div class="form-group col-12">
                        {!! Form::label('', __('Photo'), ['class' => 'form-label']) !!}
                        <div class="row">
                            <div class="col-md-12">
                            <label for="upload_photo">
                                <div class="image-upload bg-primary pointer w-100 logo_update"> <i
                                        class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                </div>
                                <input type="file" class="form-control file d-none"
                                    name="photo" id="upload_photo"
                                    data-filename="logo_update"
                                    onchange="document.getElementById('categoryIcon').src = window.URL.createObjectURL(this.files[0])">
                            </label>
                            </div>
                            <div class="logo-content mt-3 col-md-12">
                                    <img src="#"
                                        class="big-logo invoice_logo img_setting" id="categoryIcon" width="200px">
                            </div>
                        </div>
                    </div>

                    <div class="form-group  col-6">
                        {!! Form::label('', __('First Name'), ['class' => 'form-label']) !!}
                        {!! Form::text('first_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group  col-6">
                        {!! Form::label('', __('Last Name'), ['class' => 'form-label']) !!}
                        {!! Form::text('last_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group  col-6">
                        {!! Form::label('', __('Email'), ['class' => 'form-label']) !!}
                        {!! Form::text('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group  col-6">
                        {!! Form::label('', __('Phone'), ['class' => 'form-label']) !!}
                        {!! Form::text('mobile', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group  col-6">
                        {!! Form::label('', __('Date of Birth'), ['class' => 'form-label']) !!}
                        {!! Form::date('date_of_birth', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                    
                    

                    
                    <div class="modal-footer pb-0">
                       <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        </div>
    </div>
@endsection

@push('custom-script')
    <script type="text/javascript">
      
    </script>
@endpush





