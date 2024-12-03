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
                        <img alt="#" style="height:inherit;"
                            src="{{ !empty(auth()->user()->profile_image) ? asset(auth()->user()->profile_image) : asset(Storage::url('uploads/profile/avatar.png')) }}"
                            class="header-avtar">

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
                        <a href="url('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
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
        <ul class="list-unstyled gap-2">

                @if (auth()->user() && auth()->user()->type == 'admin')
                    <li class="dropdown dash-h-item drp-language">
                        <a href="{{ url('stores.create') }}" class="dropdown-item dash-head-link dropdown-toggle arrow-none cust-btn bg-primary" data-size="lg"
                            >
                            <i class="ti ti-circle-plus"></i>
                            <span class="text-store">{{ __('Create New Store') }}</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user() && auth()->user()->type == 'admin')
                    <li class="dash-h-item drp-language menu-lnk has-item">
                        @php
                            $activeStore = auth()->user()->current_store;
                            $store = \Cache::remember('store_' . $activeStore, 3600, function () use ($activeStore) {
                                return \App\Models\Store::find($activeStore);
                            });
                            $stores = auth()->user()->stores;
                        @endphp
                        <a class="dash-head-link arrow-none me-0 cust-btn megamenu-btn bg-warning" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false"
                            data-bs-placement="bottom" data-bs-original-title="Select Store">
                            <i class="ti ti-building-store"></i>
                            <span class="hide-mob">{{ ucfirst($store->name ?? '') }}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                            <input type="text" id="searchInput" class="form-control mb-2" placeholder="{{ __('Search...') }}">
                            <div id="storeList" style="max-height: 200px; overflow-y: auto;">
                                @if (auth()->user()->type == 'admin')
                                    @foreach ($stores as $store)
                                        @if ($store->is_active)
                                        <a href="@if ($activeStore == $store->id) # @else {{ url('change.store', $store->id) }} @endif"
                                            class="dropdown-item">
                                            @if ($activeStore == $store->id)
                                                <i class="ti ti-checks text-primary"></i>
                                            @endif
                                            {{ ucfirst($store->name) }}
                                        </a>
                                        @else
                                            <a href="#!" class="dropdown-item">
                                                <i class="ti ti-lock"></i>
                                                <span>{{ $store->name }}</span>
                                                @if (isset(auth()->user()->type))
                                                    @if (auth()->user()->type == 'admin')
                                                        <span class="badge bg-dark">{{ __(auth()->user()->type) }}</span>
                                                    @else
                                                        <span class="badge bg-dark">{{ __('Shared') }}</span>
                                                    @endif
                                                @endif
                                            </a>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach ($user->stores as $store)
                                        @if ($store->is_active)
                                            <a href="#"
                                                class="dropdown-item">
                                                @if ($activeStore == $store->id)
                                                    <i class="ti ti-checks text-primary"></i>
                                                @endif
                                                {{ ucfirst($store->name) }}
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </li>
                @endif

            <li class="dropdown dash-h-item drp-language">
                <a class="dash-head-link dropdown-toggle arrow-none me-0 bg-info" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-world nocolor"></i>
                    <span class="">{{ Str::upper($currentLanguage) }}</span>
                    <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                </a>

                <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                    
                    
                </div>
            </li>
        </ul>
    </div>
</div>
</header>
