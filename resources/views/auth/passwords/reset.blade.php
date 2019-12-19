@extends('layouts.main')

@section('content')

<div class="container">
   <div class="row">
      <div class="col-md-4 col-md-offset-4">

         <div class="forum-box-wrapper wrapper-box">
            <form class="forum-form login-box" method="POST" action="{{ route('password.request') }}">
               @csrf
               <input type="hidden" name="token" value="{{ $token }}">
               <h2 class="head-h2 text-center">Reset Password</h2>

               <label for="email" class="sr-only">Email address</label>
               <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>
               @if ($errors->has('email'))
                  <p class="text-danger">
                      <strong>{{ $errors->first('email') }}</strong>
                  </p>
               @endif

               <label for="password" class="sr-only">Password</label>
               <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
               @if ($errors->has('password'))
                  <p class="text-danger">
                     <strong>{{ $errors->first('password') }}</strong>
                  </p>
               @endif

               <label for="password_confirmation" class="sr-only">Password</label>
               <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
               @if ($errors->has('password_confirmation'))
                  <p class="text-danger">
                     <strong>{{ $errors->first('password_confirmation') }}</strong>
                  </p>
               @endif

               <button class="btn btn-lg btn-primary btn-block" type="submit">Reset Password</button>
            </form>

            <a class="link-to" href="{{ route('login') }}">Back to Login</a>
         </div>

      </div>
   </div>
</div>


<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Reset Password</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.request') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email or old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
