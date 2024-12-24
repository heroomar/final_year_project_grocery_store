@php
    
        $currentLanguage = 'en';
    
@endphp

@if (isset($setting['cust_theme_bg']) && $setting['cust_theme_bg'] == 'on')
    <header class="dash-header transprent-bg">
    @else
        <header class="dash-header">
@endif
<div class="header-wrapper">
    <div class="me-auto dash-mob-drp">
        <ul class="list-unstyled gap-2">
            <li class="dash-h-item mob-hamburger">
                <a href="#!" class="dash-head-link" id="mobile-collapse">
                    <div class="hamburger hamburger--arrowturn">
                        <div class="hamburger-box">
                            <div class="hamburger-inner"></div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="dropdown dash-h-item drp-company">
                <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="theme-avtar">
                        <!-- <img alt="#" style="height:inherit;"
                            src="{{ !empty(auth()->user()->profile_image) ? asset(auth()->user()->profile_image) : asset(Storage::url('uploads/profile/avatar.png')) }}"
                            class="header-avtar"> -->
                            <span>{{ strtoupper(auth()->user()->name[0] ?? 'G') }}</span>
                    </span>
                    <span class="hide-mob ms-2">
                        @if (!Auth::guest())
                            {{ __('Hi, ') }}{{ !empty(Auth::user()) ? Auth::user()->name : '' }}!
                        @else
                            {{ __('Guest') }}
                        @endif
                    </span>
                    <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                </a>
                <div class="dropdown-menu dash-h-dropdown">

                    <a href="{{ url('profile') }}" class="dropdown-item">
                        <i class="ti ti-user"></i>
                        <span>{{ __('Profile') }}</span>
                    </a>
                    <form method="POST" action="{{ url('logout') }}" id="form_logout">
                        <a  onclick="event.preventDefault(); this.closest('form').submit();"
                            class="dropdown-item">
                            <i class="ti ti-power"></i>
                            @csrf
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </li>
        </ul>
    </div>
    <div class="dash-center-drp">
        <ul class="list-unstyled exit-company-btn">
            
        </ul>
    </div>
    <div class="dash-right-drp">
        
    </div>
</div>
</header>
