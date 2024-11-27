@php
    
@endphp

@extends('layouts.guest')
@section('page-title')
    {{ __('Login') }}
@endsection

<!-- Session Status -->
@section('content')
    <div class="">
        <h2 class="mb-3 f-w-600">{{ __('Login') }}</h2>
    </div>
    <div class="">
        <!-- Session Status -->
        

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

        <form method="POST" action="{{ url('login') }}" id="form_data">
            @csrf
            <div class="form-group mb-3">
                <label class="form-label">{{ __('Email') }}</label>
                <input id="email" class="form-control" type="email" name="email" :value="old('email')" placeholder="{{ __('Enter Email') }}" required
                    autofocus />
            </div>
            <div class="form-group mb-3">
                <label class="form-label">{{ __('Password') }}</label>
                <input id="password" class="form-control" type="password" name="password" required
                    autocomplete="current-password" placeholder="{{ __('Enter Password') }}"/>
            </div>

            <div class="my-1">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-primary text-gray-600 hover:text-gray-900" href="{{ url('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            

            <div class="d-grid">
                {{-- {!! Form::hidden('type', 'admin') !!} --}}
                <button class="btn btn-primary btn-block mt-2 login_button" type="submit"> {{ __('Login') }} </button>
            </div>
            
            <p class="my-4 text-center">{{ __("Don't have an account?") }}
               
                <a href="{{ url('register') }}" class="my-4 text-primary">{{ __('Register') }}</a>
                
            </p>
            
        </form>
    </div>
@endsection

@push('scripts')
    
    <script>
        $(document).ready(function() {
            $("#form_data").submit(function(e) {
                $('#loader').fadeIn();
                $(".login_button").attr("disabled", true);
                return true;
            });
        });
    </script>
@endpush