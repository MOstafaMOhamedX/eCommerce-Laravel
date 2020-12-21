@extends('layouts.layout')

@section('title', 'Reset Password')

@section('extra-css')
    
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Montserrat%7CRoboto:300,400,700" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Styles -->
<link rel="stylesheet" href="{{ asset('/css/app.css') }}">
<link rel="stylesheet" href="{{ asset('/css/responsive.css') }}">
@endsection

@section('content')
@extends('layouts.header')
<div class="container">
    <div class="auth-pages">
        <div class="auth-left">
            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session()->get('status') }}
            </div>
            @endif @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <h2>Forgot Password?</h2>
            <div class="spacer"></div>
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                <div class="login-container">
                    <button type="submit" class="auth-button">Send Password Reset Link</button>
                </div>


            </form>
        </div>
        <div class="auth-right">
            <h2>Forgotten Password Information</h2>
            <div class="spacer"></div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel dicta obcaecati exercitationem ut atque inventore cum. Magni autem error ut!</p>
            <div class="spacer"></div>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vel accusantium quasi necessitatibus rerum fugiat eos, a repudiandae tempore nisi ipsa delectus sunt natus!</p>
        </div>
    </div>
</div>
@endsection