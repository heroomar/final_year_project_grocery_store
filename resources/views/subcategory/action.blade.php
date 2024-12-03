<span class="d-flex gap-1 justify-content-end">
<button class="btn btn-sm btn-info" data-url="{{ route('sub-category.edit', $subcategory->id) }}" data-size="md"
    data-ajax-popup="true" data-title="{{ __('Edit Sub Category') }}" data-bs-toggle="tooltip"
    title="{{ __('Edit') }}">
    <i class="ti ti-pencil"></i>
</button>
{!! Form::open([
    'method' => 'DELETE',
    'route' => ['sub-category.destroy', $subcategory->id],
    'class' => 'd-inline',
]) !!}
<button type="button" class="btn btn-sm btn-danger show_confirm"  data-bs-toggle="tooltip"
title="{{ __('Delete') }}"><i class="ti ti-trash"></i></button>
{!! Form::close() !!}
</span>
