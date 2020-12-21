@extends('layouts.layout')

@section('title', 'My Profile')

@section('extra-css')
<style>
    .profile-img {
        text-align: center;
    }

    .profile-img img {
        width: 20%;
        height: 10%;
    }

    .profile-img .file {
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 0;
        font-size: 15px;
        background: #212529b8;
    }

    .profile-img .file input {
        position: absolute;
        opacity: 0;
        right: 0;
        top: 0;
    }
</style>
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
<div class="container">
    @if (session()->has('success_message'))
    <div class="alert alert-success">
        {{ session()->get('success_message') }}
    </div>
    @endif

    @if(count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>

<div class="products-section container">
    <div class="sidebar">

        <ul>
            <li class="active"><a href="{{ route('users.edit') }}">My Profile</a></li>
            <li><a href="{{ route('orders.index') }}">My Orders</a></li>
        </ul>
    </div> <!-- end sidebar -->
    <div class="my-profile">
        <div class="products-header">
            <h1 class="stylish-heading">My Profile</h1>
        </div>

        <div>
            <form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-header bg-white border-0" style="padding-bottom: 30px">
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="profile-img" style="width: 66.6%">
                                <img src="{{ asset('img/'.Auth::user()->avatar) }}" class="rounded mx-auto d-block rounded-circle" id="img" />
                                <div class="file btn btn-lg btn-primary">
                                    Change Photo
                                    <input type="file" name="image" accept='image/*'  onchange="readURL(this)"  />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-control">
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Name"
                        required>
                </div>
                <div class="form-control">
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
                        placeholder="Email" required>
                </div>
                <div class="form-control">
                    <input id="password" type="password" name="password" placeholder="Password">
                    <div>Leave password blank to keep current password</div>
                </div>
                <div class="form-control">
                    <input id="password-confirm" type="password" name="password_confirmation"
                        placeholder="Confirm Password">
                </div>
                <div>
                    <button type="submit" class="my-profile-button">Update Profile</button>
                </div>
            </form>
        </div>

        <div class="spacer"></div>
    </div>
</div>
<script>
    function readURL(input) {
      if (input.files && input.files[0]) {
      
        var reader = new FileReader();
        reader.onload = function (e) { 
          document.querySelector("#img").setAttribute("src",e.target.result);
        };
  
        reader.readAsDataURL(input.files[0]); 
      }
    }
    </script>

@endsection
