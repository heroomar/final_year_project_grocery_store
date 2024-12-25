
{{ Form::open(['route' => 'store-expenses.store', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}

<div class="row">
    <div class="form-group  col-md-12">
        {!! Form::label('', __('Account'), ['class' => 'form-label']) !!}
        {!! Form::text('account', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>
    <div class="form-group  col-md-12">
        {!! Form::label('', __('Description'), ['class' => 'form-label']) !!}
        {!! Form::text('description', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>
    <div class="form-group  col-md-12">
        {!! Form::label('', __('Amount'), ['class' => 'form-label']) !!}
        {!! Form::text('amount', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>
    
    <div class="modal-footer pb-0">
        <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
    </div>
</div>
{!! Form::close() !!}
