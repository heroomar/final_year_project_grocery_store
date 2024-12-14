@extends('layouts.app')
@php $currency_icon = \App\Models\Utility::GetValueByName('CURRENCY', APP_THEME(), getCurrentStore()); @endphp

@section('page-title', __('POS'))
@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('POS') }}</li>
@endsection
@section('content')
    <div class="container-fluid px-2">
        <?php $lastsegment = request()->segment(count(request()->segments())) . '_' . getCurrentStore(); ?>
        <div class="mt-2 row">
            <div class="col-lg-7">
                <div class="sop-card card mb-0">
                    <div class="card-header p-2">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <h3 class="mb-0 p-2">{{ __('Product Section') }}</h3>
                            </div>
                            <div class="search-bar-left col-md-8">
                                <form class="mb-0">
                                    <div class="row gap-1" style="justify-content: flex-end;">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                                                </div>
                                                <input id="searchproduct" type="text"
                                                    data-url="{{ route('search.products') }}"
                                                    placeholder="{{ __('Search Product') }}"
                                                    class="form-control pr-4 rounded-right">
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <div class="right-content">
                            <div class="button-list b-bottom catgory-pad mb-4">
                                <div class="form-row m-0" id="categories-listing">
                                </div>
                            </div>
                            <div class="product-body-nop">
                                <div class="form-row row" id="product-listing">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 ps-lg-0">
                <div class="card m-0 h-100">
                    <div class="card-header p-2">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="mb-0 p-2">{{ __('Billing Section') }}</h3>
                            </div>
                            <div class="col-md-6">
                                {{ Form::select('customer_id', $customers, '', ['class' => 'form-control select customer_select', 'id' => 'customer', 'required' => 'required']) }}
                                {{ Form::hidden('vc_name_hidden', '', ['id' => 'vc_name_hidden']) }}
                                <input type="hidden" id="store_id" value="{{ getCurrentStore() }}">
                                <input type="hidden" id="theme_id" value="{{ APP_THEME() }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-body carttable cart-product-list carttable-scroll d-flex flex-column h-100 justify-content-between"
                        id="carthtml" style="flex: 1;">
                        @php $total = 0 @endphp
                        <div class="table-responsive">
                            <table class="table pos-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-left">{{ __('Name') }}</th>
                                        <th class="text-center">{{ __('QTY') }}</th>
                                        <th>{{ __('Tax') }}</th>
                                        <th class="text-center">{{ __('Price') }}</th>
                                        <th class="text-center">{{ __('Sub Total') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @if (session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0)
                                        @foreach (session($lastsegment) as $id => $details)
                                            @php
                                                $product = \App\Models\Product::find($details['id']);
                                                $image_url = !empty($product->cover_image_path)
                                                    ? $product->cover_image_path
                                                    : 'default.jpg';
                                                $total = $total + (float) $details['total_orignal_price'];
                                                $Tax = [];
                                            @endphp
                                            @if (getCurrentStore() == $product->store_id)
                                                <tr data-product-id="{{ $id }}"
                                                    id="product-id-{{ $id }}">
                                                    <td class="cart-images">
                                                        <img alt="Image placeholder" src="{{ get_file($image_url) }}"
                                                            class="card-image avatar rounded-circle-sale shadow hover-shadow-lg">
                                                    </td>
                                                    <td class="text-left name">{{ $details['name'] }}</td>
                                                    <td>
                                                        <span class="quantity buttons_added">
                                                            <input type="button" value="-" class="minus">
                                                            <input type="number" step="1" min="1"
                                                                max="" name="quantity" title="{{ __('Quantity') }}"
                                                                class="input-number" data-url="{{ url('update-cart/') }}"
                                                                data-id="{{ $id }}" size="4"
                                                                value="{{ $details['quantity'] }}" style="width:50px;">
                                                            <input type="button" value="+" class="plus">
                                                        </span>
                                                    </td>

                                                    <td class=" cart-summary-table">
                                                        @if((isset($tax_option['price_type']) && $tax_option['price_type'] != 'inclusive') && (isset($tax_option['shop_price']) && $tax_option['shop_price'] != 'including'))
                                                        @foreach ($Tax as $key1 => $value1)
                                                            <span class="badge badge-primary"> {{ $value1->name }}
                                                                @foreach ($value1->tax_methods() as $methods)
                                                                    {{ $methods->tax_rate }}%
                                                                @endforeach
                                                            </span>
                                                            <br>
                                                        @endforeach
                                                        @else
                                                        '-'
                                                        @endif
                                                    </td>

                                                    <td class="price text-center">
                                                        {{ currency_format_with_sym($details['orignal_price'], getCurrentStore(), APP_THEME()) }}
                                                    </td>

                                                    <td class="text-center">
                                                        <span
                                                            class="total_orignal_price">{{ currency_format_with_sym($details['total_orignal_price'], getCurrentStore(), APP_THEME()) }}</span>
                                                    </td>
                                                    <td>
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'class' => 'mb-0',
                                                            'route' => ['remove-from-cart'],
                                                            'id' => 'delete-form-' . $id,
                                                        ]) !!}
                                                        <button type="button"
                                                            class="show_confirm btn btn-sm btn-danger p-2">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                        <input type="hidden" name="session_key"
                                                            value="{{ $lastsegment }}">
                                                        <input type="hidden" name="id"
                                                            value="{{ $id }}">
                                                        {!! Form::close() !!}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <tr class="text-center no-found">
                                            <td colspan="7">{{ __('No Data Found.!') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="total-section mt-3">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <div class="left-inner ">
                                        <div class="d-flex text-end justify-content-end align-items-center">
                                            <span
                                                class="input-group-text bg-transparent">{{ $currency_icon ?? SetNumberFormat() }}</span>
                                            {{ Form::number('discount', null, ['class' => ' form-control discount', 'required' => 'required', 'placeholder' => __('Discount')]) }}
                                            {{ Form::hidden('discount_hidden', '', ['id' => 'discount_hidden']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="right-inner mt-3">
                                        <div class="d-flex text-end justify-content-md-end  justify-content-flex-start">
                                            <h6 class="mb-0 text-dark">{{ __('Sub Total') }} :</h6>
                                            <h6 class="mb-0 text-dark subtotal_price" id="displaytotal">
                                                {{ currency_format_with_sym($total, getCurrentStore(), APP_THEME()) ?? SetNumberFormat($total) }}
                                            </h6>
                                        </div>

                                        <div
                                            class="d-flex align-items-center justify-content-md-end  justify-content-flex-start">
                                            <h6 class="">{{ __('Total') }} :</h6>
                                            <h6 class="totalamount">
                                                {{ currency_format_with_sym($total, getCurrentStore(), APP_THEME()) ?? SetNumberFormat($total) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between pt-3" id="btn-pur">
                               
                                <button type="button" class="btn btn-primary rounded" data-ajax-popup="true"
                                    data-size="xl" data-align="centered" data-url="{{ route('pos.create') }}"
                                    data-title="{{ __('POS Invoice') }}"
                                    @if (session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0) @else disabled="disabled" @endif>
                                    {{ __('PAY') }}
                                </button>
                                
                                <div class="tab-content btn-empty text-end">
                                    {!! Form::open(['method' => 'post', 'route' => ['empty-cart'], 'id' => 'delete-form-emptycart']) !!}
                                    <a href="#"
                                        class="btn btn-danger show_confirm rounded m-0">{{ __('Empty Cart') }}
                                    </a>
                                    <input type="hidden" name="session_key" value="{{ $lastsegment }}"
                                        id="empty_cart">
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function formatCurrency(price) {
        var currencySymbol = "{{ $currency_icon }}";
        return currencySymbol + addCommas(price);
    }

    $(document).ready(function() {
        $("#vc_name_hidden").val($('.customer_select').val());
        $("#discount_hidden").val($('.discount').val());

        $(function() {
            getProductCategories();

        });

        if ($('#searchproduct').length > 0) {
            var url = $('#searchproduct').data('url');
            var store_id = $("#store_id").val();
            searchProducts(url, '', '0', store_id);
        }
        
        $('.customer_select').change(function() {
            $("#vc_name_hidden").val($(this).val());
        });

        $(document).on('click', '#clearinput', function(e) {
            var IDs = [];
            $(this).closest('div').find("input").each(function() {
                IDs.push('#' + this.id);
            });
            $(IDs.toString()).val('');
        });

        $(document).on('keyup', 'input#searchproduct', function() {
            var url = $(this).data('url');
            var value = this.value;
            var cat = $('.cat-active').children().data('cat-id');
            var store_id = $("#store_id").val();
            searchProducts(url, value, cat, store_id);
        });
        


        function searchProducts(url, value, cat_id, store_id = '0') {
            var session_key = $('#empty_cart').val();
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    'search': value,
                    'cat_id': cat_id,
                    'store_id': store_id,
                    'session_key': session_key
                },
                success: function(data) {
                    $('#loader').fadeOut();
                    $('#product-listing').html(data);
                }
            });
        }

        

        function getProductCategories() {
            $.ajax({
                type: 'GET',
                url: '{{ route('product.categories') }}',
                success: function(data) {
                    $('#loader').fadeOut();
                    $('#categories-listing').html(data);
                }
            });
        }

        $(document).on('click', '.toacart', function() {
            var sum = 0
            $.ajax({
                url: $(this).data('url'),
                success: function(data) {
                    $('#loader').fadeOut();

                    if (data.code == '200') {

                        $('#displaytotal').text(formatCurrency(data.product
                        .total_orignal_price));
                        $('.totalamount').text(formatCurrency(data.product.total_orignal_price));

                        if ('carttotal' in data) {
                            $.each(data.carttotal, function(key, value) {
                                $('#product-id-' + value.id +
                                    ' .total_orignal_price').text(formatCurrency(
                                    value.total_orignal_price));
                                sum += value.total_orignal_price;
                            });
                            $('#displaytotal').text(formatCurrency(sum));

                            $('.totalamount').text(formatCurrency(sum));

                            $('.discount').val('');
                        }

                        $('#tbody').append(data.carthtml);
                        $('.no-found').addClass('d-none');
                        $('.carttable #product-id-' + data.product.id +
                            ' input[name="quantity"]').val(data.product.quantity);
                        $('#btn-pur button').removeAttr('disabled');
                        $('.btn-empty button').addClass('btn-clear-cart');

                    }
                },
                error: function(data) {
                    $('#loader').fadeOut();
                    data = data.responseJSON;
                    show_toastr('{{ __('Error') }}', data.error, 'error');
                }
            });
        });


        
    

        $(document).on('change keyup', '#carthtml input[name="quantity"]', function(e) {
            e.preventDefault();
            var ele = $(this);
            var sum = 0;
            var quantity = ele.closest('span').find('input[name="quantity"]').val();
            var discount = $('.discount').val();
            var session_key = $('#empty_cart').val();
            if (quantity != 0 && quantity != null) {
                $.ajax({
                    url: ele.data('url'),
                    method: "patch",
                    data: {
                        id: ele.attr("data-id"),
                        quantity: quantity,
                        discount: discount,
                        session_key: session_key
                    },
                    success: function(data) {
                        $('#loader').fadeOut();
                        if (data.code == '200') {

                            if (quantity == 0) {
                                ele.closest(".row").hide(250, function() {
                                    ele.closest(".row").remove();
                                });
                                if (ele.closest(".row").is(":last-child")) {
                                    $('#btn-pur button').attr('disabled', 'disabled');
                                    $('.btn-empty button').removeClass('btn-clear-cart');
                                }
                            }

                            $.each(data.product, function(key, value) {
                                sum += value.total_orignal_price;
                                $('#product-id-' + value.id +
                                    ' .total_orignal_price').text(
                                        formatCurrency(value.total_orignal_price));
                            });

                            $('#displaytotal').text(formatCurrency(sum));
                            if (discount <= sum) {
                                $('.totalamount').text(data.discount);
                            } else {
                                $('.totalamount').text(formatCurrency(0));
                            }
                        }
                    },
                    error: function(data) {
                        $('#loader').fadeOut();
                        data = data.responseJSON;
                        show_toastr('{{ __('Error') }}', data.error, 'error');
                    }
                });
            }
        });

        $(document).on('click', '.remove-from-cart', function(e) {
            e.preventDefault();

            var ele = $(this);
            var sum = 0;

            if (confirm('{{ __('Are you sure?') }}')) {
                ele.closest(".row").hide(250, function() {
                    ele.closest(".row").parent().parent().remove();
                });
                if (ele.closest(".row").is(":last-child")) {
                    $('#btn-pur button').attr('disabled', 'disabled');
                    $('.btn-empty button').removeClass('btn-clear-cart');
                }
                $.ajax({
                    url: ele.data('url'),
                    method: "DELETE",
                    data: {
                        id: ele.attr("data-id"),

                    },
                    success: function(data) {
                        $('#loader').fadeOut();
                        if (data.code == '200') {

                            $.each(data.product, function(key, value) {
                                sum += value.total_orignal_price;
                                $('#product-id-' + value.id +
                                    ' .total_orignal_price').text(addCommas(
                                    value.total_orignal_price));
                            });

                            $('#displaytotal').text(addCommas(sum));

                            show_toastr('success', data.success, 'success')
                        }
                    },
                    error: function(data) {
                        $('#loader').fadeOut();
                        data = data.responseJSON;
                        show_toastr('{{ __('Error') }}', data.error, 'error');
                    }
                });
            }
        });

        $(document).on('click', '.btn-clear-cart', function(e) {
            e.preventDefault();

            if (confirm('{{ __('Remove all items from cart?') }}')) {

                $.ajax({
                    url: $(this).data('url'),
                    data: {
                        session_key: session_key
                    },
                    success: function(data) {
                        location.reload();
                    },
                    error: function(data) {
                        $('#loader').fadeOut();
                        data = data.responseJSON;
                        show_toastr('{{ __('Error') }}', data.error, 'error');
                    }
                });
            }
        });

        $(document).on('click', '.btn-done-payment', function(e) {
            e.preventDefault();
            var ele = $(this);

            $.ajax({
                url: ele.data('url'),

                method: 'GET',
                data: {
                    vc_name: $('#vc_name_hidden').val(),
                    warehouse_name: $('#warehouse_name_hidden').val(),
                    discount: $('#discount_hidden').val(),
                },
                beforeSend: function() {
                    ele.remove();
                },
                success: function(data) {
                    $('#loader').fadeOut();
                    if (data.code == 200) {
                        show_toastr('success', data.success, 'success')
                    }

                },
                error: function(data) {
                    $('#loader').fadeOut();
                    data = data.responseJSON;
                    show_toastr('{{ __('Error') }}', data.error, 'error');
                }

            });

        });

        $(document).on('click', '.category-select', function(e) {
            var cat = $(this).data('cat-id');
            var white = 'text-white';
            var dark = 'text-dark';
            $('.category-select').find('.tab-btns').removeClass('btn-primary')
            $(this).find('.tab-btns').addClass('btn-primary')
            $('.category-select').parent().removeClass('cat-active');
            $('.category-select').find('.card-title').removeClass('text-white').addClass('text-dark');
            $('.category-select').find('.card-title').parent().removeClass('text-white').addClass(
                'text-dark');
            $(this).find('.card-title').removeClass('text-dark').addClass('text-white');
            $(this).find('.card-title').parent().removeClass('text-dark').addClass('text-white');
            $(this).parent().addClass('cat-active');
            var url = '{{ route('search.products') }}'
            var store_id = $('#store_id').val();
            searchProducts(url, '', cat, store_id);
        });




        $(document).on('keyup', '.discount', function() {
            var discount = $('.discount').val();
            var total = $('#displaytotal').text();
            var maintotal = parseFloat(total.replace("$", "").replace(",", ""))
            if (discount <= maintotal) {
                $("#discount_hidden").val(discount);
            } else {
                $("#discount_hidden").val(maintotal);
            }
            $.ajax({
                url: "{{ route('cartdiscount') }}",
                method: 'POST',
                data: {
                    discount: discount,
                },
                success: function(data) {
                    $('#loader').fadeOut();
                    //if (discount <= maintotal) {
                        $('.totalamount').text(data.total);
                    //} else {
                    //    $('.totalamount').text(addCommas(0));
                    //}
                },
                error: function(data) {
                    $('#loader').fadeOut();
                    data = data.responseJSON;
                    show_toastr('{{ __('Error') }}', data.error, 'error');
                }
            });
            var price = {{ $total }}
            var total_amount = price - discount;
            $('.totalamount').text(total_amount);
        });
    });


    // Product Variant script

    $(document).on('change', '.variant-selection', function() {
        var variants = [];
        
    });


    $(document).on('click', '.toacartvariant', function() {

        var sum = 0;
        var id = $(this).attr('data-id');
        var session_key = "{{ $lastsegment }}";
        var variants = [];
        $(".variant-selection").each(function(index, element) {
            variants.push(element.value);
        });

        if (jQuery.inArray('0', variants) != -1) {
            show_toastr('Error', "{{ __('Please select all option.') }}", 'error');
            return false;
        }

        var variation_ids = $('#variant_id').val();

        $.ajax({
            url: '{{ route('pos.add.to.cart', ['__product_id', 'session_key', 'variation_id']) }}'
                .replace('__product_id', id).replace('session_key', session_key).replace('variation_id',
                    variation_ids ?? 0),
            data: {
                "_token": "{{ csrf_token() }}",
                variants: variants.join(' : '),
            },
            success: function(data) {
                $('#loader').fadeOut();
                if (data.code == '200') {

                    $('#displaytotal').text(formatCurrency(data.product.total_orignal_price));
                    $('.totalamount').text(formatCurrency(data.product.total_orignal_price));

                    if ('carttotal' in data) {
                        $.each(data.carttotal, function(key, value) {
                            $('#product-id-' + value.id + ' .total_orignal_price').text(
                                formatCurrency(value.total_orignal_price));
                            sum += value.total_orignal_price;
                        });
                        $('#displaytotal').text(formatCurrency(sum));

                        $('.totalamount').text(formatCurrency(sum));

                        $('.discount').val('');
                    }

                    $('#tbody').append(data.carthtml);
                    $('.no-found').addClass('d-none');
                    $('.carttable #product-id-' + data.product.id + ' input[name="quantity"]').val(
                        data.product.quantity);
                    $('#btn-pur button').removeAttr('disabled');
                    $('.btn-empty button').addClass('btn-clear-cart');

                }
            },
            error: function(data) {
                $('#loader').fadeOut();
                data = data.responseJSON;
                show_toastr('{{ __('Error') }}', data.error, 'error');
            }
        });
    });

    $(document).on('click', '.add_to_cart_variant', function() {
        $('#commonModal').modal('hide');
    });
</script>
<script>
    var site_currency_symbol_position = 'Rs';
    var site_currency_symbol = 'Rs';
</script>


<script>

    var filename = $('#filename').val()

    function saveAsPDF() {
        var element = document.getElementById('printableArea');
        var opt = {
            margin: 0.3,
            filename: filename,
            image: {type: 'jpeg', quality: 1},
            html2canvas: {scale: 4, dpi: 72, letterRendering: true},
            jsPDF: {unit: 'in', format: 'A2'}
        };
        html2pdf().set(opt).from(element).save();
    }

    $(document).on('click', '.payment-done-btn', function (e) {
        // alert('payment-done-btn');
        $('.modal-dialog').removeClass('modal-xl');
        e.preventDefault();
        var ele = $(this);
        $.ajax({
            url: "{{ route('pos.data.store') }}",
            method: 'GET',
            data: {
                vc_name: $('#vc_name_hidden').val(),
                store_id: $('#store_id').val(),
                discount : $('#discount_hidden').val(),
                price:$('.totalamount').text(),
            },
            beforeSend: function () {
                ele.remove();
            },
            success: function (data) {
                $('#loader').fadeOut();
                if (data.code == 200) {
                    $('#carthtml').load(document.URL +  ' #carthtml');
                    show_toastr('success', data.success, 'success')
                }
            },
            error: function (data) {
                $('#loader').fadeOut();
                data = data.responseJSON;
                show_toastr('{{ __("Error") }}', data.error, 'error');
            }

        });
    });
</script>
@endpush