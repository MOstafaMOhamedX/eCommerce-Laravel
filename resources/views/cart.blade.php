@extends('layouts.layout')

@section('title')
Laravel Ecommerce | Shopping Cart
@endsection

@section('content')
@include('layouts.header')

<div class="breadcrumbs">
    <div class="breadcrumbs-container container">
        <div>
            <a href="#">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Shopping Cart</span>
        </div>
        @include('layouts.search')
    </div>
</div> <!-- end breadcrumbs -->

<div class="cart-section container">
    <div>
        @if (session()->has('success_message'))
        <div class="alert alert-success">
            {{ session()->get('success_message') }}
        </div>
        @endif

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        @if (Cart::Count() > 0)
        <h2>{{ Cart::Count() }} item(s) in Shopping Cart</h2>
        <div class="cart-table">
            @foreach (Cart::Content() as $item)
            <div class="cart-table-row">
                <div class="cart-table-row-left">
                    <a href="{{ route('shop.show', $item->model->slug) }}">
                        <img src={{ productImage($item->model->image) }} alt="item" class="cart-table-img">
                    </a>
                    <div class="cart-item-details">
                        <div class="cart-table-item">
                            <a href="{{ route('shop.show', $item->model->slug) }}">{{ $item->model->name }}</a>
                        </div>
                        <div class="cart-table-description">{{ $item->model->details }}</div>
                    </div>
                </div>
                <div class="cart-table-row-right">
                    <div class="cart-table-actions">
                        <form action="{{ route('cart.destroy', $item->rowId) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cart-options">Remove</button>
                        </form>

                        <form action="{{ route('cart.switchToSaveForLater', $item->rowId) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="cart-options">Save for Later</button>
                        </form>
                    </div>
                    <div>
                        <select class="quantity" data-id="{{ $item->rowId }}"
                            data-productQuantity="{{ $item->model->quantity }}">
                            @for ($i = 1; $i < 5 + 1 ; $i++) <option {{ $item->qty == $i ? 'selected' : '' }}>{{ $i }}
                                </option>
                                @endfor
                        </select>
                    </div>
                    <div>{{ presentPrice($item->subtotal) }}</div>
                </div>
            </div> <!-- end cart-table-row -->
            @endforeach
        </div> <!-- end cart-table -->


        @if (!session()->has('coupon'))
        <a href="#" class="have-code">Have a Code?</a>

        <div class="have-code-container">
            <form action="{{ route('coupon.store') }}" method="POST">
                @csrf
                <input type="text" name="coupon_code" id="coupon_code">
                <button type="submit" class="button button-plain">Apply</button>
            </form>
        </div> <!-- end have-code-container -->
        @endif
        <div class="cart-totals">
            <div class="cart-totals-left">
                Shipping is free because we’re awesome like that. Also because that’s additional stuff I don’t feel
                like figuring out :).
            </div>

            <div class="cart-totals-right" style="width: 40%;">
                <div>
                    Subtotal <br>
                    @if (session()->has('coupon'))
                    <form action="{{ route('coupon.destroy') }}" method="POST" style="display: inline;">
                        @csrf
                        @method('Delete')
                        Discount(<button type="submit" style="color: red;font-size: small">Remove</button>)
                    </form> <br>
                    <hr>
                    New Subtotal <br>
                    @endif
                    Tax (5%)<br>
                    <span class="cart-totals-total">Total</span>
                </div>
                <div class="cart-totals-subtotal">
                    {{ presentPrice(Cart::subtotal()) }} <br>
                    @if (session()->has('coupon'))

                    -{{ presentPrice($discount)}}<br>
                    <hr>
                    {{ presentPrice($newSubtotal) }} <br>
                    @endif
                    {{ presentPrice($newTax) }} <br>
                    <span class="cart-totals-total">{{ presentPrice($newTotal) }}</span>
                </div>
            </div>
        </div> <!-- end cart-totals -->

        <div class="cart-buttons">
            <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
            <a href="{{ route('checkout.index') }}" class="button-primary">Proceed to Checkout</a>
        </div>


        @else

        <h3>No items in Cart!</h3>
        <div class="spacer"></div>
        <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
        <div class="spacer"></div>

        @endif


        @if (Cart::instance('saveForLater')->count() > 0)
        <h2>{{ Cart::instance('saveForLater')->count() }} item(s) in Shopping Cart</h2>
        <div class="cart-table">
            @foreach (Cart::instance('saveForLater')->content() as $item)
            <div class="cart-table-row">
                <div class="cart-table-row-left">
                    <a href="{{ route('shop.show', $item->model->slug) }}">
                        <img src="{{ productImage($item->model->image) }}" alt="item" class="cart-table-img">
                    </a>
                    <div class="cart-item-details">
                        <div class="cart-table-item">
                            <a href="{{ route('shop.show', $item->model->slug) }}">{{ $item->model->name }}</a>
                        </div>
                        <div class="cart-table-description">{{ $item->model->details }}</div>
                    </div>
                </div>
                <div class="cart-table-row-right">
                    <div class="cart-table-actions">
                        <form action="{{ route('SaveForLater.destroy', $item->rowId) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cart-options">Remove</button>
                        </form>

                        <form action="{{ route('SaveForLater.switchToCart', $item->rowId) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="cart-options">Move To Cart</button>
                        </form>
                    </div>
                    <div>{{ $item->model->presentPrice() }}</div>
                </div>
            </div> <!-- end cart-table-row -->
            @endforeach
        </div> <!-- end cart-table -->
        @else

        <h3>You have no items Saved for Later.</h3>
        <div class="spacer"></div>

        @endif



    </div>

</div> <!-- end cart-section -->
@include('layouts.might-like-section')

@endsection

@section('extra-js')
<script src="{{ asset('js/app.js') }}"></script>
<script>
    (function() {
                const classname = document.querySelectorAll('.quantity')
                Array.from(classname).forEach(function(element) {
                    element.addEventListener('change', function() {
                        const id = element.getAttribute('data-id')
                        const productQuantity = element.getAttribute('data-productQuantity')
                        axios.patch(`/cart/${id}`, {
                                quantity: this.value,
                                productQuantity: productQuantity
                            })
                            .then(function(response) {
                                // console.log(response);
                                window.location.href = '{{ route('cart.index') }}'
                            })
                            .catch(function(error) {
                                // console.log(error);
                                window.location.href = '{{ route('cart.index') }}'
                            });
                    })
                })
            })();

</script>
@endsection