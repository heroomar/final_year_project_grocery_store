@extends('layouts.app')

@section('page-title')
    {{ __('Product') }}
@endsection

@php
    $logo = asset(Storage::url('uploads/profile/'));
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('product.index') }}">{{ __('Product') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Edit') }}</li>
@endsection
@section('action-button')
    <div class=" text-end d-flex all-button-box justify-content-md-end justify-content-center">
        <a href="#" class="btn  btn-primary " id="submit-all" data-title="{{ __('Update Product') }}"
            data-toggle="tooltip" title="{{ __('Update Product') }}">
            <i class="ti ti-plus drp-icon"></i> <span class="ms-2 me-2">{{ __('Update') }}</span> </a>
    </div>
@endsection
@php
    $theme_name = theme_name();
    
@endphp
@section('content')
    {{ Form::model($product, ['route' => ['product.update', $product->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'id' => 'choice_form', 'class' => 'choice_form_edit']) }}
    <div class="row pt-4">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <h5 class="mb-3">{{ __('Main Informations') }}</h5>
                    <div class="card border">
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <div class="form-group col-12">
                                    {!! Form::label('', __('Name'), ['class' => 'form-label']) !!}
                                    {!! Form::text('name', null, ['class' => 'form-control name']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 parmalink ">
                                    {!! Form::label('', __('Permalink'), ['class' => 'form-label col-md-3']) !!}
                                    <div class="d-flex flex-wrap gap-3">
                                        {!! Form::text('slug', null, ['class' => 'form-control slug col-12']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    {!! Form::label('', __('Category'), ['class' => 'form-label']) !!}
                                    {!! Form::select('maincategory_id', $MainCategory, null, [
                                        'class' => 'form-control',
                                        'data-role' => 'tagsinput',
                                        'id' => 'maincategory_id',
                                    ]) !!}
                                </div>
                                <div class="form-group  col-12 subcategory_id_div" data_val='0'>
                                    {!! Form::label('', __('Subcategory'), ['class' => 'form-label']) !!}
                                    <span>
                                        {!! Form::select('subcategory_id', $SubCategory, null, [
                                            'class' => 'form-control',
                                            'data-role' => 'tagsinput',
                                            'id' => 'subcategory-dropdown',
                                        ]) !!}
                                    </span>
                                </div>
                            </div>
                            

                            <div class="row">
                                <div class="form-group col-12 product-weight">
                                    {!! Form::label('', __('Weight(Kg)'), ['class' => 'form-label ']) !!}
                                    {!! Form::number('product_weight', null, ['class' => 'form-control', 'min' => '0', 'step' => '0.01']) !!}
                                </div>
                            </div>
                            <div class="row product-price-div">
                                <div class="form-group col-md-6 col-12 product_price">
                                    {!! Form::label('', __('Price'), ['class' => 'form-label']) !!}
                                    {!! Form::number('price', null, ['class' => 'form-control', 'min' => '0', 'step' => '0.01']) !!}
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    {!! Form::label('', __('Sale Price'), ['class' => 'form-label']) !!}
                                    {!! Form::number('sale_price', null, ['class' => 'form-control', 'min' => '0', 'step' => '0.01']) !!}
                                </div>
                            </div>
                            <div class="product-stock-div">
                                <hr>
                                <h4>{{ __('Product Stock') }}</h4>
                                    <div class="row" >
                                        <div class="form-group col-md-6 col-12 product_stock">
                                            {!! Form::label('', __('Stock'), ['class' => 'form-label']) !!}
                                            {!! Form::number('product_stock', null, ['class' => 'form-control productStock']) !!}
                                        </div>
                                        
                                    </div>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <h5 class="mb-3">{{ __('Product Image') }}</h5>
                    <div class="card border">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        {{ Form::label('sub_images', __('Upload Product Images'), ['class' => 'form-label f-w-800']) }}
                                        <div class="dropzone dropzone-multiple" data-toggle="dropzone1"
                                            data-dropzone-url="http://" data-dropzone-multiple>
                                            <div class="fallback">
                                                <div class="custom-file">
                                                    <input type="file" name="file" id="dropzone-1"
                                                        class="fcustom-file-input"
                                                        onchange="document.getElementById('dropzone').src = window.URL.createObjectURL(this.files[0])"
                                                        multiple>
                                                    <img id="dropzone"src="" width="20%" class="mt-2" />
                                                    <label class="custom-file-label"
                                                        for="customFileUpload">{{ __('Choose file') }}</label>
                                                </div>
                                            </div>
                                            <ul
                                                class="dz-preview dz-preview-multiple list-group list-group-lg list-group-flush">
                                                <li class="list-group-item px-0">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="avatar">
                                                                <img class="rounded" src=""
                                                                    alt="Image placeholder" data-dz-thumbnail>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="text-sm mb-1" data-dz-name>...</h6>
                                                            <p class="small text-muted mb-0" data-dz-size>
                                                            </p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <a href="#" class="dropdown-item" data-dz-remove>
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group pt-3">
                                            <div class="row gy-3 gx-3">
                                                @foreach ($product_image as $file)
                                                    <div class="col-sm-6 product_Image {{ 'delete_img_' . $file->id }}"
                                                        data-id="{{ $file->id }}">
                                                        <div
                                                            class="position-relative p-2 border rounded border-primary overflow-hidden rounded">
                                                            <img src="/{{ get_file($file->image_path, APP_THEME()) }}"
                                                                alt="" class="w-100">
                                                            <div
                                                                class="position-absolute text-center top-50 end-0 start-0 pb-3">
                                                                <a href="{{ get_file($file->image_path, APP_THEME()) }}"
                                                                    download=""
                                                                    data-original-title="{{ __('Download') }}"
                                                                    class="btn btn-sm btn-primary me-2"><i
                                                                        class="ti ti-download"></i></a>
                                                                <a href="javascript::void(0)" class="btn btn-sm btn-danger deleteRecord"
                                                                    name="deleteRecord" data-id="{{ $file->id }}"><i
                                                                        class="ti ti-trash"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cover_image"
                                            class="col-form-label">{{ __('Upload Cover Image') }}</label>
                                        <input type="file" name="cover_image" id="cover_image"
                                            class="form-control custom-input-file"
                                            onchange="document.getElementById('upcoverImg').src = window.URL.createObjectURL(this.files[0]);"
                                            multiple>
                                        <img id="upcoverImg"
                                            src="/{{ get_file($product->cover_image_path, APP_THEME()) }}" width="20%"
                                            class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
                <div class="col-lg-4 col-12">
                    <h5 class="mb-3">{{ __('About product') }}</h5>
                    <div class="card border">
                        <div class="card-body">
                            <div class="form-group">
                                {{ Form::label('description', __('Product Description'), ['class' => 'form-label']) }}
                                {{ Form::textarea('description', null, ['class' => 'form-control  summernote-simple-product', 'rows' => 1, 'placeholder' => __('Product Description'), 'id' => 'description']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('specification', __('Product Specification'), ['class' => 'form-label']) }}
                                {{ Form::textarea('specification', null, ['class' => 'form-control  summernote-simple-product', 'rows' => 1, 'placeholder' => __('Product Specification'), 'id' => 'specification']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('detail', __('Product Details'), ['class' => 'form-label']) }}
                                {{ Form::textarea('detail', null, ['class' => 'form-control  summernote-simple-product', 'rows' => 1, 'placeholder' => __('Product Details'), 'id' => 'detail']) }}
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@push('custom-script')
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/repeater.js') }}"></script>
    <script src="{{ asset('assets/css/summernote/summernote-bs4.js') }}"></script>
    <script>
        $(document).ready(function() {
            attribute_option_data();
            type();

            // tag
            $('.select2').select2({
                tags: true,
                createTag: function(params) {
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true
                    };
                }
            });
            // main-cat
            $('#maincategory_id').on('change', function() {
                var id = $(this).val();
                var val = $('.subcategory_id_div').attr('data_val');
                var data = {
                    id: id,
                    val: val
                }
                $.ajax({
                    url: "{{ route('get.product.subcategory') }}",
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        $('#loader').fadeOut();
                        $.each(response, function(key, value) {
                            $("#subcategory-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        var val = $('.subcategory_id_div').attr('data_val', 0);
                        $('.subcategory_id_div span').html(response.html);
                        comman_function();
                    },


                })
            });
            //stock
            $(document).on("change", "#enable_product_stock", function() {
                if ($("#enable_product_stock").prop("checked")) {
                    $("#options").show();
                    $('.stock_div_status').hide();
                } else {
                    $("#options").hide();
                    $('.stock_div_status').show();
                }
            });

            function type() {
                if ($('#enable_product_stock').is(":checked") == true) {
                    $("#options").show();
                    $('.stock_div_status').hide();
                } else {
                    $("#options").hide();
                    $('.stock_div_status').show();
                }
            }

            // prview video
            $("#preview_type").change(function() {
                $(this).find("option:selected").each(function() {
                    var optionValue = $(this).attr("value");
                    if (optionValue == 'Video Url') {

                        $('#video_url_div').removeClass('d-none');
                        $('#video_url_div').addClass('d-block');

                        $('#preview-iframe-div').addClass('d-none');
                        $('#preview-iframe-div').removeClass('d-block');

                        $('#preview-video-div').addClass('d-none');
                        $('#preview-video-div').removeClass('d-block');

                    } else if (optionValue == 'iFrame') {
                        $('#video_url_div').addClass('d-none');
                        $('#video_url_div').removeClass('d-block');

                        $('#preview-iframe-div').removeClass('d-none');
                        $('#preview-iframe-div').addClass('d-block');

                        $('#preview-video-div').addClass('d-none');
                        $('#preview-video-div').removeClass('d-block');

                    } else if (optionValue == 'Video File') {

                        $('#video_url_div').addClass('d-none');
                        $('#video_url_div').removeClass('d-block');

                        $('#preview-iframe-div').addClass('d-none');
                        $('#preview-iframe-div').removeClass('d-block');

                        $('#preview-video-div').removeClass('d-none');
                        $('#preview-video-div').addClass('d-block');
                    }
                });
            }).change();
        });
        $(document).ready(function() {
            if ($('#enable_custom_field').prop('checked') == true) {
                $('#custom_value').show();
            }

            $(document).on("change", "#enable_custom_field", function() {
                $('#custom_value').hide();
                if ($(this).prop('checked') == true) {
                    $('#custom_value').show();
                }
            });
        });
        $('#custom_field_repeater_basic').repeater({
            initEmpty: false,
            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
        $('.deleteRecord').on('click', function() {
            var id = $(this).data("id");
            $.ajax({
                url: '{{ route('products.file.detele', '__product_id') }}'.replace('__product_id', id),
                type: 'DELETE',
                data: {
                    id: id,
                },
                success: function(data) {
                    $('#loader').fadeOut();
                    $('.delete_img_' + id).hide();
                    if (data.success) {
                        show_toastr('success', data.success, 'success');
                    }
                }

                });
        });
    </script>
    <script>
        // display variant hide show
        $(document).on("change", "#enable_product_variant", function() {
            $('.product-weight').show();
            $('.product-stock-div').show();
            $('#Product_Variant_Select').hide();
            $('.Product_Variant_atttt').hide();
            $('.attribute_combination').hide();
            $('.product-price-div').show();
            if ($(this).prop('checked') == true) {
                $('.product-price-div').hide();
                $('.product-stock-div').hide();
                $('.product-weight').hide();
                $('#Product_Variant_Select').show();
                $('.Product_Variant_atttt').show();
                $(".use_for_variation").removeClass("d-none");
                var inputValue = $('.attribute_option_data').val();
                if (inputValue != []) {
                    $('.attribute_combination').show();
                }



                attribute_option_data();
            }
        });

        //variation option on off
        if ($('.enable_product_variant').prop('checked') == true) {
            var inputValue = $('.attribute_option_data').val();
            if (inputValue != []) {
                var b = $('.attribute_option_data').closest('.parent-clase').find('.input-options');
                var enableVariationValue = b.data('enable-variation');
                var dataid = b.attr('data-id');
                $('.enable_variation_' + dataid).on('change', function() {
                    if ($('.enable_variation_' + dataid).prop('checked') == true) {
                        update_attribute();
                    } else {
                        $('.attribute_options_datas').empty();
                    }
                });

            }
        }
        //variation option on off
        $(document).on("change", "#enable_product_variant", function() {
            if ($('.enable_product_variant').prop('checked') == true) {

                var inputValue = $('.attribute_option_data').val();
                if (inputValue != []) {
                    var b = $('.attribute_option_data').closest('.parent-clase').find('.input-options');
                    var enableVariationValue = b.data('enable-variation');
                    var dataid = b.attr('data-id');
                    $('.enable_variation_' + dataid).on('change', function() {
                        if ($('.enable_variation_' + dataid).prop('checked') == true) {
                            $('.attribute_combination').show();
                            update_attribute();
                        } else {
                            $('.attribute_options_datas').empty();
                        }
                    });
                    if ($('.enable_variation_' + dataid).prop('checked') != true) {
                        $('.attribute_options_datas').empty();
                    }

                }
            }
        });
        // edit attribute data
        function attribute_option_data() {
           
        }

        

    </script>

    {{-- Dropzones  --}}
    <script>
        var Dropzones = function() {
            var e = $('[data-toggle="dropzone1"]'),
                t = $(".dz-preview");

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            e.length && (Dropzone.autoDiscover = !1, e.each(function() {
                var e, a, n, o, i;
                e = $(this), a = void 0 !== e.data("dropzone-multiple"), n = e.find(t), o = void 0, i = {
                    url: "{{ route('product.store') }}",
                    headers: {
                        'x-csrf-token': CSRF_TOKEN,
                    },
                    thumbnailWidth: null,
                    thumbnailHeight: null,
                    previewsContainer: n.get(0),
                    previewTemplate: n.html(),
                    maxFiles: 10,
                    parallelUploads: 10,
                    autoProcessQueue: false,
                    uploadMultiple: true,
                    acceptedFiles: a ? null : "image/*",
                    success: function(file, response) {
                        if (response.flag == "success") {
                            show_toastr('success', response.msg, 'success');
                            window.location.href = "{{ route('product.create') }}";
                        } else {
                            show_toastr('Error', response.msg, 'error');
                        }
                    },
                    error: function(file, response) {
                        // Dropzones.removeFile(file);
                        if (response.error) {
                            show_toastr('Error', response.error, 'error');
                        } else {
                            show_toastr('Error', response, 'error');
                        }
                    },
                    init: function() {
                        var myDropzone = this;

                        this.on("addedfile", function(e) {
                            !a && o && this.removeFile(o), o = e
                        })
                    }
                }, n.html(""), e.dropzone(i)
            }))
        }()

        $('#submit-all').on('click', function() {

            $('#submit-all').attr('disabled', true);
            var fd = new FormData();

            var file = document.getElementById('cover_image').files[0];
            
            if (file) {
                fd.append('cover_image', file);
            }
            
            var files = $('[data-toggle="dropzone1"]').get(0).dropzone.getAcceptedFiles();
            $.each(files, function(key, file) {
                fd.append('product_image[' + key + ']', $('[data-toggle="dropzone1"]')[0].dropzone
                    .getAcceptedFiles()[key]); // attach dropzone image element
            });

            var other_data = $('#choice_form').serializeArray();

            $.each(other_data, function(key, input) {
                fd.append(input.name, input.value);
            });

            
            
                $.ajax({
                    url: "{{ route('product.update', $product->id) }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: fd,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(data) {
                        $('#loader').fadeOut();
                        if (data.flag == "success") {
                            $('#submit-all').attr('disabled', true);
                            window.location.href = "{{ route('product.index') }}" + '?id=2';


                        } else {
                            show_toastr('Error', data.msg, 'error');
                            $('#submit-all').attr('disabled', false);
                        }
                    },
                    error: function(data) {
                        $('#loader').fadeOut();

                        $('#submit-all').attr('disabled', false);
                        // Dropzones.removeFile(file);
                        if (data.error) {
                            show_toastr('Error', data.error, 'error');
                        } else {
                            show_toastr('Error', data, 'error');
                        }
                    },
                });
            


        });

        // Product Attribute
        $(document).ready(function() {
            $(document).on("change", ".product_attribute", function() {

                if ($('.enable_product_variant').prop('checked') == true) {
                    $(".use_for_variation").removeClass("d-none");
                } else {
                    $(".use_for_variation").addClass("d-none");
                }
            });

            if ($('#enable_product_variant').prop('checked') == true) {
                $('.product-price-div').hide();
                $('.product-stock-div').hide();
                $('.product-weight').hide();
            }
        });
    </script>
@endpush
