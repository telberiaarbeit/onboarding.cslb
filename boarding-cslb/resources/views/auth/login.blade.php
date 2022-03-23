@extends('layouts.private')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="webapp-vertical-middle">
                
                <form method="POST" action="{{ route('login.post') }}" id="webapp-form-login" class="webapp-form">
                    @csrf
                    <div class="row justify-content-center">
                        @if(Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">
                                <small>
                                    <i class="la la-warning"></i>
                                    {{ Session::get('message') }}
                                </small>
                            </p>
                        @endif
                        <div class="col-md-12 form-item">
                            <img src="{{ url('resources/images/webapp-logo.png') }}" class="webapp-logo" height="84" width="126" />
                        </div>
                        <div class="col-md-12 form-item">
                            {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Benutzer">
                            <small class="error-msg">
                                @if ($errors->has('email'))
                                    {{ $errors->first('email') }}
                                @endif
                            </small> --}}
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Benutzer">
                            <small class="error-msg">
                                @if ($errors->has('name'))
                                    {{ $errors->first('name') }}
                                @endif
                            </small>
                        </div>
                        <div class="col-md-12 form-item">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Passwort">
                            <small class="error-msg">
                                @if ($errors->has('password'))
                                    {{ $errors->first('password') }}
                                @endif
                            </small>
                        </div>
                        <div class="col-md-12 form-item login-button-main">
                            <button type="submit" class="btn btn-primary webapp-button">
                                {{ __('ANMELDEN') }}
                            </button>
                            <!-- @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif -->
                        </div>
                    </div>

                    <!-- <div class="row mb-3">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div> -->

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
