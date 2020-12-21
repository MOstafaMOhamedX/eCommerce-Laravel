<header>
    <div class="top-nav container">

        <div class="top-nav-left">
            <div class="logo"><a style="text-decoration: none; color:white;"
                    href="{{ route('landing-page') }}">Ecommerce</a></div>
            <ul>
                <li>
                    <a style="text-decoration: none; color:white;" href="{{ route('shop.index') }}">shop</a>
                </li>
                <li>
                    <a style="text-decoration: none; color:white;" >About</a>
                </li>
            </ul>
        </div>
        <div class="top-nav-right">

            @if ( Auth::check() )
            <ul>
                <li>
                    <a style="text-decoration: none; color:white;" href="{{ route('users.edit') }}">My Account</a>
                </li>
                <li><a style="text-decoration: none; color:white;" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <li>
                    <a style="text-decoration: none; color:white;" href="{{ route('cart.index') }}">Cart</a>
                </li>
            </ul>
            @else
            <ul>
                <li>
                    <a style="text-decoration: none; color:white;" href="{{ route('register') }}">Sign Up</a></li>
                </li>
                <li><a style="text-decoration: none; color:white;" href="{{ route('login') }}">Login</a></li>
                </li>
                <li>
                    <a style="text-decoration: none; color:white;" href="{{ route('cart.index') }}">Cart</a>
                </li>
            </ul>
            @endif

            @if (Cart::count()>0)
            <span class="cart-count">
                <span>{{ Cart::count() }}</span>
            </span>
            @endif

        </div>

    </div> <!-- end top-nav -->

</header>