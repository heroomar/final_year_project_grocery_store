<span class="d-flex gap-1 justify-content-end">
<a class="btn btn-sm btn-warning" href="{{ route('coupon.show', $coupon->id) }}"  data-bs-toggle="tooltip"
title="{{ __('Show') }}">
    <i class="ti ti-eye"></i>
</a>
<button class="btn btn-sm btn-info"
    data-url="{{ route('coupon.edit', $coupon->id) }}"
    data-size="lg" data-ajax-popup="true"
    data-title="{{ __('Edit Coupon') }}"  data-bs-toggle="tooltip"
    title="{{ __('Edit') }}">
    <i class="ti ti-pencil"></i>
</button>
{!! Form::open(['method' => 'DELETE', 'route' => ['coupon.destroy', $coupon->id], 'class' => 'd-inline']) !!}
<button type="button" class="btn btn-sm btn-danger show_confirm"  data-bs-toggle="tooltip"
title="{{ __('Delete') }}">
    <i class="ti ti-trash"></i>
</button>
{!! Form::close() !!}
</span>