<!-- navigation.blade.php -->
<nav x-data="{ open: false }" class="nav-wrapper">
    <div class="nav-container">
        <div class="nav-inner">
            <!-- Logo -->
            <div class="nav-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('logo/logo-shop.png') }}" alt="Logo" class="nav-logo-img">
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
   <!-- Navigation Admin Link (visible only for admins) -->
   @if(Auth::check() && Auth::user()->role === 'admin')
   <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
       {{ __('Quản trị') }}
   </x-nav-link>
@endif
            </div>


            <!-- Search Form -->
            <div class="nav-search">
                <form action="{{ route('shop.search') }}" method="GET" class="search-form">
                    <input type="text" name="query" placeholder="Tìm kiếm sản phẩm..." class="search-input">
                    <button type="submit" class="search-button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="search-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 011.3 7.8l5.5 5.5a1 1 0 11-1.4 1.4l-5.5-5.5A4 4 0 118 4z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </form>
            </div>

         
            <!-- User Auth Links -->
            <div class="cart-product">
                <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                    {{ __('Giỏ Hàng') }}
                </x-nav-link>

                @if(Auth::check())
                    <div class="dropdown">
                        <button class="auth-button" onclick="document.querySelector('.dropdown-menu').classList.toggle('show')">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('profile.edit') }}" class="dropdown-link">
                                {{ __('Profile') }}
                            </a>
                            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                @csrf
                                <a href="javascript:void(0);" onclick="document.getElementById('logout-form').submit();" class="dropdown-link">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </div>
                @else
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Login') }}
                    </x-nav-link>
                @endif
            </div>
        </div>
    </div>
</nav>




<style>
    .nav-wrapper {
        background-color: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        position: sticky;
        top: 0;
        z-index: 50;
    }

    .nav-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .nav-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 4rem;
    }

    .nav-logo-img {
        height: 8rem;
    }

    .nav-links {
        display: flex;
        gap: 1.5rem;
    }

    .cart-product {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .auth-button {
        background: #f9fafb;
        border: 1px solid #d1d5db;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #374151;
        cursor: pointer;
    }

    .auth-button:hover {
        background: #f3f4f6;
    }

    .dropdown {
        position: relative;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 0.375rem;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        min-width: 150px;
        z-index: 100;
        padding: 0.5rem 0;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-link {
        display: block;
        padding: 0.5rem 1rem;
        color: #374151;
        text-decoration: none;
    }

    .dropdown-link:hover {
        background-color: #f3f4f6;
        color: #1f2937;
    }

    .nav-links a,
    .cart-product a,
    .mobile-nav a {
        text-decoration: none !important;
        color: #374151;
        font-weight: 500;
        position: relative;
    }

    .nav-links a::after,
    .cart-product a::after,
    .mobile-nav a::after {
        content: '';
        position: absolute;
        width: 0%;
        height: 2px;
        background: #3b82f6;
        bottom: -4px;
        left: 0;
        transition: width 0.3s ease-in-out;
    }

    .nav-links a:hover::after,
    .cart-product a:hover::after,
    .mobile-nav a:hover::after {
        width: 100%;
    }

    .nav-links a:hover,
    .cart-product a:hover,
    .mobile-nav a:hover {
        color: #1f2937;
    }

    .nav-hamburger {
        display: none;
    }

    .hamburger-btn {
        background: transparent;
        border: none;
        padding: 0.5rem;
    }

    .hamburger-icon {
        width: 1.5rem;
        height: 1.5rem;
        color: #6b7280;
    }

    @media (max-width: 768px) {
        .nav-links {
            display: none;
        }

        .nav-hamburger {
            display: flex;
        }
    }

    .mobile-nav {
        background: #ffffff;
        padding: 1rem;
    }

    .mobile-nav a {
        display: block;
        padding: 0.5rem 0;
    }
    /* Style cho form tìm kiếm */
.nav-search {
    display: flex;
    align-items: center;
}

.search-form {
    display: flex;
    align-items: center;
    position: relative;
}

.search-input {
    width: 200px;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    color: #374151;
    outline: none;
}

.search-input:focus {
    border-color: #3b82f6;
}

.search-button {
    background-color: #3b82f6;
    border: none;
    border-radius: 0.375rem;
    padding: 0.5rem;
    margin-left: 0.5rem;
    cursor: pointer;
}

.search-button .search-icon {
    width: 1.2rem;
    height: 1.2rem;
    color: white;
}

.search-button:hover {
    background-color: #2563eb;
}

@media (max-width: 768px) {
    .search-input {
        width: 150px;
    }
}

</style>
