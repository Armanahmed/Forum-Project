@extends('layouts.main')

@section('content')

<div class="container">
   <div class="row">
      <div class="col-md-4 col-md-offset-4">

         <div class="forum-box-wrapper wrapper-box">
            <form class="forum-form login-box" method="POST" action="{{ route('login') }}">
               @csrf
               <h2 class="head-h2 text-center">Log in</h2>
               <label for="email" class="sr-only">Email address</label>
               <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>
               @if ($errors->has('email'))
                  <p class="text-danger">
                      <strong>{{ $errors->first('email') }}</strong>
                  </p>
               @endif
               <label for="password" class="sr-only">Password</label>
               <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
               @if ($errors->has('password'))
                  <p class="text-danger">
                     <strong>{{ $errors->first('password') }}</strong>
                  </p>
               @endif


               <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </form>

            <a class="link-to" href="{{ route('password.request') }}">Forgot Password ?</a>
         </div>

      </div>
   </div>
</div>

@endsection