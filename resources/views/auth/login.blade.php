@extends('layouts.auth-layout')
@section('title', 'Login')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container py-5 h-100 mt-5">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                <div class="row g-0">
                    <div class="col-lg-6">
                    <div class="card-body p-md-5 mx-md-4">
                        <div class="text-center">
                            <img src="/img/logo3.png"
                                style="width: 150px;" alt="logo">
                            <h4 class="mt-1 mb-5 pb-1">Educare College Inc.</h4>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    {{ $message }}
                                </div>
                            @endif
                        <p>Please login to your account</p>
                        @if (session('alert'))
                        <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
                         @endif
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus>
                            <label class="form-label">Username</label>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
        
                        <div class="form-outline mb-4">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label class="form-label" for="form2Example22">Password</label>
                        </div>
        
                        <div class="text-center pt-1 pb-1">
                            <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">{{ __('Login') }}</button>
                            {{-- <a class="text-muted text-end" href="#!">Forgot password?</a> --}}
                        </div>
        
                        <div class="d-flex align-items-center justify-content-center pb-4">
                            {{-- <a class="nav-link" href="{{ route('register') }}">{{ __('Want to be an Educarian? Register') }}</a> --}}
                            <a class="nav-link" href="{{url('register')}}">{{ __('Want to be an Educarian? Register') }}</a>
                        </div>
        
                        </form>
        
                    </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                    <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                        <h5 class="mb-0 wel">Welcome to</h5>
                        <h1 class="mb-0 wel display-3 fw-bold">Educare College Inc.</h1>
                        <p class="small mb-0  tagline1">"We aspire to be a model school of the new millenium -a special place for people and ideas"</p>
                    
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection