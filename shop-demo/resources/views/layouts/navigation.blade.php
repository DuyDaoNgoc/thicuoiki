<nav x-data="{ open: false }" class="nav-wrapper">
    <div class="nav-container">
        <div class="nav-inner">
            <!-- Logo -->
            <div class="nav-logo">
                <a href="{{ route('home') }}">
                    <x-application-logo class="nav-logo-img" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="nav-links">
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('Trang chủ') }}
                </x-nav-link>
                <x-nav-link :href="route('products')" :active="request()->routeIs('products')">
                    {{ __('Sản phẩm') }}
                </x-nav-link>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                            {{ __('Quản trị') }}
                        </x-nav-link>
                    @endif
                @endauth
            </div>

            <!-- User Auth Links -->
            <div class="cart-product">
                <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                    {{ __('Giỏ Hàng') }}
                </x-nav-link>

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="auth-button">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Login') }}
                    </x-nav-link>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="nav-hamburger">
                <button @click="open = ! open" class="hamburger-btn">
                    <svg class="hamburger-icon" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation -->
    <div :class="{ 'block': open, 'hidden': ! open }" class="mobile-nav hidden">
        <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
            {{ __('Trang chủ') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('products')" :active="request()->routeIs('products')">
            {{ __('Sản phẩm') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
            {{ __('Giỏ hàng') }}
        </x-responsive-nav-link>

        @auth
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                    {{ __('Quản trị') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        @else
            <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                {{ __('Login') }}
            </x-responsive-nav-link>
            <footer class="bg-dark text-white mt-5 p-4 text-center">
    <div class="container">
        <p class="mb-1">&copy; {{ date('Y') }} Shop Demo. All rights reserved.</p>
       
    </div>
</footer>

        @endauth
    </div>
</nav>


<style>
    /* Custom Classes */
    .cart-product {
        gap: 12px;
        display: flex;
        align-items: center;
    }

    .nav-wrapper {
        background-color: #ffffff;
        border-bottom: 1px solid #e2e8f0;
    }

    .dark .nav-wrapper {
        background-color: #2d3748;
        border-color: #374151;
    }

    .nav-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .nav-inner {
        display: flex;
        justify-content: space-between;
        height: 4rem;
        align-items: center;
    }

    .nav-logo-img {
        height: 2.25rem;
        width: auto;
        fill: currentColor;
    }

    .nav-links {
        display: flex;
        align-items: center;
    }

    .nav-links > * + * {
        margin-left: 2rem;
    }

    .nav-auth {
        display: flex;
        align-items: center;
        margin-left: 1.5rem;
    }

    .auth-link {
        font-size: 0.875rem;
        color: #6b7280;
        transition: 0.2s;
    }

    .auth-link:hover {
        color: #374151;
    }

    .auth-button {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        background: white;
        color: #6b7280;
        border-radius: 0.375rem;
    }

    .auth-input {
        padding: 0.5rem;
        margin: 0.5rem 0;
        border: 1px solid #ccc;
        border-radius: 0.375rem;
        width: 100%;
    }

    .nav-hamburger {
        display: flex;
        align-items: center;
    }

    .hamburger-btn {
        padding: 0.5rem;
        color: #9ca3af;
    }

    .hamburger-icon {
        height: 1.5rem;
        width: 1.5rem;
    }

    .mobile-nav {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        background: #fff;
    }

    .dark .mobile-nav {
        background: #1f2937;
    }

    /* Responsive Styles */
    @media (max-width: 639px) {
        .nav-links {
            display: none;
        }

        .mobile-nav {
            display: block;
        }

        .auth-input-mobile {
            padding: 0.5rem;
            margin: 0.5rem 0;
            border: 1px solid #ccc;
            border-radius: 0.375rem;
            width: 100%;
        }

        .auth-button-mobile {
            padding: 0.5rem;
            background-color: #3490dc;
            color: white;
            border: none;
            border-radius: 0.375rem;
            width: 100%;
        }
    }
</style>
