@extends('layouts.app')

@section('page-title')
  {{ __('Product') }}
@endsection

@php
  $logo = asset(Storage::url('uploads/profile/'));
@endphp

@section('breadcrumb')
  <li class="breadcrumb-item" aria-current="page"><a href="{{ route('product.index') }}">{{ __('Product') }}</a></li>
  <li class="breadcrumb-item" aria-current="page">{{ __('Create') }}</li>
@endsection
@section('action-button')
  <div class=" text-end d-flex all-button-box justify-content-md-end justify-content-center">
    <a href="#" class="btn  btn-primary " id="submit-all" data-title="{{ __('Create Product') }}" data-toggle="tooltip"
      title="{{ __('Create Product') }}">
      <i class="ti ti-plus drp-icon"></i> <span class="ms-2 me-2">{{ __('Save') }}</span> </a>
  </div>
@endsection
@php
  
  $theme_name = theme_name();
  
@endphp
@section('content')
  {{ Form::open(['route' => 'product.store', 'method' => 'post', 'id' => 'choice_form', 'enctype' => 'multipart/form-data']) }}
  <div class="row pt-4">
    <div class="col-md-12">
      <div class="row">
        <div class="col-lg-4 col-md-6 col-12">
          <h5 class="mb-3">{{__('Main Informations')}}</h5>
          <div class="card border">
            <div class="card-body">
              <div class="row">
                <div class="form-group col-12">
                  {!! Form::label('', __('Name'), ['class' => 'form-label']) !!}
                  {!! Form::text('name', null, ['class' => 'form-control name']) !!}
                </div>
              </div>
              <div class="row">
                <div class="form-group col-12 parmalink " style =  "display: none; ">
                  {!! Form::label('', __('parmalink'), ['class' => 'form-label col-md-3']) !!}
                  <div class="d-flex flex-wrap gap-3">
                    <input class="input-group-text col-12"  readonly id="basic-addon2" value="{{ $link }}">
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
                    {!! Form::select('subcategory_id', [], null, [
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
                  


                  
                  </div>
                    <div class="row" >
                      <div class="form-group col-md-6 col-12 product_stock">
                        {!! Form::label('', __('Stock'), ['class' => 'form-label']) !!}
                        {!! Form::number('product_stock', 0, ['class' => 'form-control productStock']) !!}
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
                    <div class="dropzone dropzone-multiple" data-toggle="dropzone1" data-dropzone-url="http://"
                      data-dropzone-multiple>
                      <div class="fallback">
                        <div class="custom-file">
                          <input type="file" name="file" id="dropzone-1" class="fcustom-file-input"
                            onchange="document.getElementById('dropzone').src = window.URL.createObjectURL(this.files[0])"
                            multiple>
                          <img id="dropzone"src="" width="20%" class="mt-2" />
                          <label class="custom-file-label" for="customFileUpload">{{ __('Choose file') }}</label>
                        </div>
                      </div>
                      <ul class="dz-preview dz-preview-multiple list-group list-group-lg list-group-flush">
                        <li class="list-group-item px-0">
                          <div class="row align-items-center">
                            <div class="col-auto">
                              <div class="avatar">
                                <img class="rounded" src="" alt="Image placeholder" data-dz-thumbnail>
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
                  </div>
                  <div class="form-group">
                    <label for="cover_image" class="col-form-label">{{ __('Upload Cover Image') }}</label>
                    <input type="file" name="cover_image" id="cover_image" class="form-control custom-input-file"
                      onchange="document.getElementById('upcoverImg').src = window.URL.createObjectURL(this.files[0]);"
                      multiple>
                    <img id="upcoverImg" src="" width="20%" class="mt-2" />
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


  <script>
    $(document).ready(function() {
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

      var link = $('.slug').val();
      var focusOutCalled = false;

      // permalink
      
      //stock
      $('#options').hide();
      $('.stock_stats').show();
      $(document).on("change", "#enable_product_stock", function() {
        $('#options').prop('checked', false);
        if ($(this).prop('checked')) {
          $('.stock_stats').hide();
          $('#options').show();
        } else {
          $('.stock_stats').show();
          $('#options').hide();
        }

      });

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
    $(document).on("change", "#enable_custom_field", function() {
      $('#custom_value').hide();
      $('.custom_field').hide();
      if ($(this).prop('checked') == true) {
        $('#custom_value').show();
        $('.custom_field').show();
      }
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
  </script>


  <script>
    // display variant hide show
    $(document).on("change", "#enable_product_variant", function() {
      $('.product-price-div').show();
      $('.product-stock-div').show();
      $('.product-weight').show();
      $('#use_for_variation').addClass("d-none");
      $('.product_price input').prop('readOnly', false);
      $('.product_discount_amount input').prop('readOnly', false);
      $('.product_discount_type input').prop('readOnly', false);
      $('.attribute_options_datas').hide();

      if ($(this).prop('checked') == true) {
        $('.product-price-div').hide();
        $('.product-stock-div').hide();
        $('.product-weight').hide();
        $("#use_for_variation").removeClass("d-none");
        $('.product_price input').prop('readOnly', true);
        $('.product_discount_amount input').prop('readOnly', true);
        $('.product_discount_type input').prop('readOnly', true);
        $('.attribute_options_datas').show();

      }
    });



    $(document).on('change', '#attribute_id', function() {
      $('#attribute_options').html("<h3 class='d-none'>Variation</h3>");
      var selectedOptions = $("#attribute_id option:selected");
      selectedOptions.each(function() {
        var optionValue = $(this).val();
        var optionText = $(this).text();

        add_more_choice_option(optionValue, optionText);

        var attribute_id = optionValue;

        
      });
    });



    function update_attribute() {
      var variant_val = $('.attribute option:selected')
        .toArray().map(item => item.text).join();
      if (variant_val == '') {
        return;
      }
      
    }
    $(document).on("change", ".attribute_option_data", function() {
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
    });

    $(document).on("change", "#enable_product_variant", function() {
      if ($(this).prop('checked') == true) {

        $(document).on('change', '.attribute', function() {
          var b = $(this).closest('.parent-clase').find('.input-options');
          var enableVariationValue = b.data('enable-variation');
          var dataid = b.attr('data-id');
          if ($('.enable_variation_' + dataid).prop('checked') == true) {
            update_attribute();
          }
        });
        var b = $(this).closest('.parent-clase').find('.input-options');
        var enableVariationValue = b.data('enable-variation');
        var dataid = b.attr('data-id');
        if ($('.enable_variation_' + dataid).prop('checked') == true) {
          update_attribute();
        }
      }
    });

    $(document).on('change', '#attribute_id', function() {
      $('#attribute_options').html("<h3 class='d-none'>Variation</h3>");
      $.each($("#attribute_id option:selected"), function() {
        add_more_choice_option($(this).val(), $(this).text());
      });
    });
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
      

      
      
      // Append Summernote content to FormData
      fd.append('description', $('#description').summernote('code'));
      fd.append('specification', $('#specification').summernote('code'));
      fd.append('detail', $('#detail').summernote('code'));
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

      
      if(1) {
        $.ajax({
          url: "{{ route('product.store') }}",
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

              window.location.href = "{{ route('product.index') }}" + '?id=1';

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
      }

    });
  </script>
@endpush
