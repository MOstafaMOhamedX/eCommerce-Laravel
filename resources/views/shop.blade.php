@extends('layouts.layout')
@section('title')
    Laravel Ecommerce | Products
@endsection
@section('content')
    @extends('layouts.header')
    <div class="breadcrumbs">
        <div class="breadcrumbs-container container">
            <div>
                <a href="{{ route('landing-page') }}">Home</a>
                <i class="fa fa-chevron-right breadcrumb-separator"></i>
                <span >Shop</span>
            </div>
            @include('layouts.search')
        </div>
    </div> <!-- end breadcrumbs -->

    <div class="products-section container">
        <div class="sidebar">
            <h3>By Category</h3>
            <ul>
                @foreach ($categories as $category)
                    <li class="{{ setActiveCategory($category->slug) }}">
                        <a href="{{ route('shop.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div> <!-- end sidebar -->
        <div>
            <div class="products-header">
                <h1 class="stylish-heading">{{ $categoryName }}
                </h1>
                <div>
                    <strong>Price: </strong>
                    <a href="{{ route('shop.index', ['category'=> request()->category, 'sort' => 'low_high' , 'products' => $products ] ) }}">Low to High</a> |
                    <a href="{{ route('shop.index', ['category'=> request()->category, 'sort' => 'high_low' , 'products' => $products ] ) }}">High to Low</a>

                </div>
            </div>

            <div class="products text-center">

                @forelse ($products as $product)
                <div class="product">
                    <a href="{{ route('shop.show', $product->slug) }}">
                        <img src="{{productImage($product->image) }}"alt="product"></a>
                    <a href="{{ route('shop.show', $product->slug) }}">
                        <div class="product-name">{{ $product->name }}</div>
                    </a>
                    <div class="product-price">{{ presentPrice($product->price)  }}</div>
                </div>
                @empty
                    <div style="text-align: left">No items found</div>
                @endforelse

            </div> <!-- end products -->

            <div class="spacer"></div>

        </div>
    </div>
@endsection