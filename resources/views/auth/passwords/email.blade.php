@extends('layouts.guest')

@section('subtitle','| Forgot Password')

@section('box_content')
    <p class="login-box-msg">Enter your email address below to send password reset link.</p>

    <form action="{{route('password.email')}}" method="post">
        @csrf

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                value="{{ old('email') }}" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Request new password</button>
            </div>
        </div>

    </form>

    <p class="mt-3 mb-1">
        <a href="{{route('login')}}">Back to login</a>
    </p>
    @if  (Route::has('register'))
        <p class="mb-0">
            <a href="register.html" class="text-center">Register</a>
        </p>
    @endif
@endsection
