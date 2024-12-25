<span class="d-flex gap-1 justify-content-end">

<a href="javascript:void(0)"
    data-url="{{ route('order.order_view', ($order->id)) }}" data-size="lg"
    data-ajax-popup="true" data-title="{{ __('Order') }}    #{{ $order->product_order_id }}"
    class="x-3 btn btn-sm align-items-center btn btn-sm btn-warning" data-bs-toggle="tooltip"
    data-original-title="{{ __('Show') }}" data-bs-toggle="tooltip"
    title="{{ __('Show') }}">
    <i class="ti ti-eye"></i>
</a>
<a href="{{ route('order.view', ($order->id)) }}"
    class="btn btn-sm btn-info" data-bs-toggle="tooltip"
    title="{{ __('Edit') }}">
    <i class="ti ti-pencil"></i>
</a>
{!! Form::open(['method' => 'DELETE', 'route' => ['order.destroy', $order->id], 'class' => 'd-inline']) !!}
<button type="button" class="btn btn-sm btn-danger show_confirm" data-bs-toggle="tooltip"
title="{{ __('Delete') }}">
    <i class="ti ti-trash"></i>
</button>
{!! Form::close() !!}
</span>
