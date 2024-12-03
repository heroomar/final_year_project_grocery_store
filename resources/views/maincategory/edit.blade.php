{{Form::model($mainCategory, array('route' => array('main-category.update', $mainCategory->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}

@if (isset(auth()->user()->currentPlan) && auth()->user()->currentPlan->enable_chatgpt == 'on')
<div class="d-flex justify-content-end mb-1">
    <a href="#" class="btn btn-primary me-2 ai-btn" data-size="lg" data-ajax-popup-over="true" data-url="{{ route('generate',['category']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}" data-title="{{ __('Generate Content With AI') }}">
        <i class="fas fa-robot"></i> {{ __('Generate with AI') }}
    </a>
</div>
@endif

<div class="row">
    <div class="form-group  col-md-12">
        {!! Form::label('', __('Title'), ['class' => 'form-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}

        <div class="row">
            <div class="col-md-12">
            <label for="upload_image">
                <div class="image-upload bg-primary pointer w-100 logo_update"> <i
                        class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                </div>
                <input type="file" class="form-control file d-none"
                    name="image" id="upload_image"
                    data-filename="logo_update"
                    onchange="document.getElementById('categoryImage').src = window.URL.createObjectURL(this.files[0])">
            </label>
            </div>
            <div class="logo-content mt-3 col-md-12">
                    <img src="{{ get_file($mainCategory->image, APP_THEME()) ?? '#' }}"
                        class="big-logo invoice_logo img_setting" id="categoryImage" width="200px">
            </div>
        </div>
        
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('', __('Icon'), ['class' => 'form-label']) !!}
        <div class="row">
            <div class="col-md-12">
            <label for="upload_icon_image">
                <div class="image-upload bg-primary pointer w-100 logo_update"> <i
                        class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                </div>
                <input type="file" class="form-control file d-none"
                    name="icon_image" id="upload_icon_image"
                    data-filename="logo_update"
                    onchange="document.getElementById('categoryIcon').src = window.URL.createObjectURL(this.files[0])">
            </label>
            </div>
            <div class="logo-content mt-3 col-md-12">
                    <img src="{{ get_file($mainCategory->icon_image, APP_THEME()) ?? '#' }}"
                        class="big-logo invoice_logo img_setting" id="categoryIcon" width="200px">
            </div>
        </div>
    </div>


    <div class="form-group col-md-4">
        {!! Form::label('', __('Trending'), ['class' => 'form-label']) !!}
        <div class="form-check form-switch">
            <input type="hidden" name="trending" value="0">
            {!! Form::checkbox("trending", 1, null, ["class" => "form-check-input input-primary", "id"=>"customCheckdef1trending"]) !!}
            <label class="form-check-label" for="customCheckdef1trending"></label>
        </div>
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('', __('Status'), ['class' => 'form-label']) !!}
        <div class="form-check form-switch">
            <input type="hidden" name="status" value="0">
            {!! Form::checkbox('status', 1, null, [
                'class' => 'form-check-input status',
                'id' => 'status',
            ]) !!}
            <label class="form-check-label" for="status"></label>
        </div>
    </div>
    <div class="modal-footer pb-0">
        <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
    </div>
</div>
{!! Form::close() !!}
