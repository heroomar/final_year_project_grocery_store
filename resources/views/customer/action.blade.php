<span class="d-flex gap-1 justify-content-end">
    
        <a href="{{ route('customer.show', $customer->id) }}"
            class="btn btn-sm btn-icon btn-info" data-bs-placement="top" data-bs-toggle="tooltip" title="{{ __('View Orders') }}">
            <i class="ti ti-shopping-cart"></i>
        </a>
        <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-sm btn-info"
            data-url="{{ route('customer.edit', $customer->id) }}" data-size="md"
            data-ajax-popup="true" data-title="{{ __('Edit') }}" data-bs-toggle="tooltip"
            title="{{ __('Edit') }}">
            <i class="ti ti-pencil"></i>
        </a>
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['customer.destroy', $customer->id],
            'class' => 'd-inline',
        ]) !!}
        <button type="button" class="btn btn-sm btn-danger show_confirm" data-bs-toggle="tooltip"
        title="{{ __('Delete') }}"><i
                class="ti ti-trash"></i></button>
        {!! Form::close() !!}
</span>