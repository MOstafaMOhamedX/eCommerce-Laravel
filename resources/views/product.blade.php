@extends('layouts.layout')
@section('title')
Laravel Ecommerce | {{ $product->name }}
@endsection
@section('extra-css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/comments.css') }}">
@endsection

@section('content')
@include('layouts.header')

<div class="breadcrumbs">
    <div class="breadcrumbs-container container">
        <div>
            <a href="{{ route('landing-page') }}">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span><a href="{{ route('shop.index') }}">Shop</a></span>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>{{ $product->name }}</span>
        </div>
        @include('layouts.search')
    </div>
</div> <!-- end breadcrumbs -->

<div class="product-section container">
    <div>
        <div class="product-section-image">
            <img src="{{ productImage($product->image) }}" alt="product" class="active" id="currentImage">
        </div>
        <div class="product-section-images">
            <div class="product-section-thumbnail selected">
                <img src="{{ productImage($product->image) }}" alt="product">
            </div>
            @if ($product->images)
            @foreach (json_decode($product->images, true) as $image)
            <div class="product-section-thumbnail">
                <img src="{{ productImage($image) }}" alt="product">
            </div>
            @endforeach
            @endif
        </div>
    </div>
    <div class="product-section-information">
        <h1 class="product-section-title">{{ $product->name }}</h1>
        <div class="product-section-subtitle">{{ $product->details }}</div>
        <div>
            @if ($product->quantity > 0)
            <div class="badge badge-success">{{ $stocklvl }}</div>
            @else
            <div class="badge badge-danger">{{ $stocklvl }}</div>
            @endif
        </div>
        <div class="product-section-price">{{ presentPrice($product->price) }}</div>

        <p>
            {!! $product->description !!}
        </p>

        <p>&nbsp;</p>
        @if ($product->quantity > 0 )
        <form action="{{ route('cart.store' ,$product) }}" method="POST">
            @csrf
            @method('POST')
            <button type="submit" class="button button-plain">Add to Cart</button>
        </form>
        @endif
    </div>
</div> <!-- end product-section -->


<div class="container">
    <h1 style="text-align: center">Comments</h1>
    <div class="col-md-12" id="fbcomment">
        <div class="header_comment">
            <div class="row">
                <div class="col-md-6 text-left">
                    <span class="count_comment">{{ count($comments) }} Comments</span>
                </div>
                <div class="col-md-6 text-right">

                </div>
            </div>
        </div>
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


        <div class="body_comment">
            <div class="row">
                <div class="avatar_comment col-md-1">
                    @if (auth::check())
                    <img src="{{ productImage(Auth::user()->avatar) }}" alt="avatar" />
                    @else
                    <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar" />
                    @endif
                </div>
                <div class="box_comment col-md-11" style="border: none; padding-bottom: 50px">
                    <form action="{{ route('comment.store') }}" method="post">
                        @csrf
                        <div class="box_post">
                            <div class="pull-left" style="width: 80%">
                                <input type="comment" class="form-control" placeholder="Leave Comment" name="comment">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="parent" value="0">
                            </div>
                            <div class="pull-right" style="width: 20%">
                                <button type="submit" class="btn btn-primary mb-2"
                                    style="width: 90%; height: 100%; border-radius: 10px; background-color: #0d6efd">Comment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <ul id="list_comment" class="col-md-12">
                    @foreach ($comments as $parent)
                    @if ($parent->parent === 0)
                    <!-- Start List Comment 1 -->
                    <li class="box_reply row">
                        <div class="result_comment col-md-11">
                            <div class="avatar_comment col-md-1" style="float: left; width: 55px">
                                <img src="{{ productImage($parent->user->avatar) }}" alt="avatar" />
                            </div>
                            <h4>{{ $parent->user->name }}</h4>
                            <p>{{ $parent->comment }}</p>
                            <p style="color: red">{{ \Carbon\Carbon::parse($parent->created_at)->diffForHumans() }}</p>
                            @foreach ($comments as $chiled)
                            @if ($chiled->parent == $parent->id)
                            <ul class="child_replay" style="padding: 0px 100px;">
                                <li class="box_reply row" style="padding-top: 20px; border-left: 1px solid black">
                                    <div class="result_comment col-md-11">
                                        <div class="avatar_comment col-md-1" style="float: left;">
                                            <img src="{{ productImage($chiled->user->avatar) }}" alt="avatar" />
                                        </div>
                                        <h4>{{ $chiled->user->name }}</h4>
                                        <p>{{ $chiled->comment }}</p>
                                        <p style="color: red">
                                            {{ \Carbon\Carbon::parse($chiled->created_at)->diffForHumans() }}</p>
                                    </div>
                                </li>
                            </ul>
                            @endif
                            @endforeach
                            <form action="{{  route('comment.store')  }}" method="post" style="padding-top: 10px">
                                @csrf
                                <div class="box_post">
                                    <div class="pull-left" style="width: 80% ; padding-right: 10px">
                                        <input type="comment" class="form-control" placeholder="Reply" name="comment">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="parent" value="{{ $parent->id }}">
                                    </div>
                                    <div class="pull-right" style="width: 20%">
                                        <button type="submit" class="btn btn-primary mb-2"
                                            style="width: 90%; height: 100%; border-radius: 10px ">Reply</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                    <hr style="border: 1px solid black;">
                    @endif
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>

@include('layouts.might-like-section')
@endsection

@section('extra-js')
<script>
    (function() {
                const currentImage = document.querySelector('#currentImage');
                const images = document.querySelectorAll('.product-section-thumbnail');

                images.forEach((element) => element.addEventListener('click', thumbnailClick));

                function thumbnailClick(e) {
                    currentImage.classList.remove('active');

                    currentImage.addEventListener('transitionend', () => {
                        currentImage.src = this.querySelector('img').src;
                        currentImage.classList.add('active');
                    })

                    images.forEach((element) => element.classList.remove('selected'));
                    this.classList.add('selected');
                }

            })();

</script>
@endsection