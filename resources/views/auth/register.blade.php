

@extends('layouts.guest')

@section('page-title')
    {{ __('Register') }}
@endsection





@section('content')
    <div class="">
        
        <h2 class="mb-3 f-w-600">{{__('Register')}}</h2>
    </div>
    <div class="">
        <!-- Validation Errors -->
        <?php 
        // print_r(session()->all());
        // if (count($errors->bags)) dd($errors->bags);
        if ( $errors->count() > 0 ){
            foreach ($errors->all() as $error) {
                echo '<p style="color:red;" >'.$error.'</p>';
            }
        }
         ?>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input name="plan_id" type="hidden" value="{{ request()->query('plan_id') }}">
            <div class="form-group mb-3">
                <label class="form-label" for="name">{{ __('Name') }}</label>
                <input id="name" class="form-control" type="text" name="name" :value="old('name')" required
                placeholder="{{ __('Enter Name') }}" autofocus />
            </div>
            <div class="form-group mb-3">
                <label class="form-label" for="name">{{ __('Store name') }}</label>
                <input id="name" class="form-control" type="text" name="store_name" :value="old('store_name')"
                placeholder="{{ __('Enter Store name') }}" required autofocus />
            </div>
            <div class="form-group mb-3">
                <label class="form-label" for="email">{{ __('Email') }}</label>
                <input id="email" class="form-control" type="email" name="email" :value="old('email')" placeholder="{{ __('Enter Email') }}" required />
            </div>
            <div class="form-group mb-3">
                <label class="form-label" for="password">{{ __('Password') }}</label>
                <input id="password" class="form-control" type="password" name="password" placeholder="{{ __('Enter Password') }}" required
                    autocomplete="new-password" />
            </div>
            <div class="form-group mb-3">
                <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation"
                placeholder="{{ __('Enter Confirm Password') }}" required />
            </div>



            <div class="d-grid">
                <button class="btn btn-primary btn-block mt-2" type="submit"> {{ __('Register') }} </button>
            </div>
        </form>
    </div>
    <p class="mb-2 text-center">
       {{__(' Already have an account?')}}
        <a href="{{ route('login') }}" class="f-w-400 text-primary">{{ __('Login') }}</a>
    </p>
@endsection


@push('scripts')

@endpush
