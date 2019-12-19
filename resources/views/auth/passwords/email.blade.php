@extends('layouts.main')

@section('content')

<div class="container">
   <div class="row">
      <div class="col-md-4 col-md-offset-4">

         <div class="forum-box-wrapper wrapper-box">
            <form class="forum-form login-box" method="POST" action="{{ route('password.email') }}">
               @csrf
               <h2 class="head-h2 text-center">Reset Password</h2>
               <label for="email" class="sr-only">Email address</label>
               <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>
               @if ($errors->has('email'))
                  <p class="text-danger">
                      <strong>{{ $errors->first('email') }}</strong>
                  </p>
               @endif

               <button class="btn btn-lg btn-primary btn-block" type="submit">Send Password Reset Link</button>
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
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
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
