@extends('site.app')
@section('title', 'Login')
@section('content')
    <section class="section-pagetop bg-dark">
        <div class="container clearfix">
            <h2 class="title-page">Login</h2>
        </div>
    </section>
    <section class="section-content bg padding-y">
        <div class="container">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <header class="card-header">
                        <h4 class="card-title mt-2">Sign In</h4>
                        <div class="btn-group white p-3" style="">
                            <a class="btn btn-warning" href="{{ route('login.provider', 'google') }}">
                                <i class="fab fa-google  fa-fw" aria-hidden="true"></i>
                            </a>
                            <a class="btn btn-facebook" title="Facebook" target="_blank" href="{{ route('login.provider', 'facebook') }}"><i
                                    class="fab fa-facebook-f  fa-fw"></i></a>
                            <a class="btn btn-dark" title="github" target="_blank" href="{{ route('login.provider', 'github') }}"><i
                                    class="fab fa-github fa-fw"></i></a>
                            <a class="btn btn-primary" title="Youtube" target="_blank" href="{{ route('login.provider', 'bitbucket') }}""><i
                                    class="fab fa-bitbucket  fa-fw"></i></a>
                        </div>
                    </header>
                    <article class="card-body">
                        <form action="{{ route('login') }}" method="POST" role="form">
                            @csrf
                            <div class="form-group">
                                <label for="email">E-Mail Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group row mr-auto">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-block"> Login </button>
                            </div>
                        </form>
                    </article>
                    <div class="border-top card-body text-center">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></div>
                </div>
            </div>
        </div>
    </section>
@stop
