 @extends('front.layouts.app')
 @section('title', 'Travel Blog')

 @section('content')
 <div class="account-main">
    <section class="section-10 py-5 mt-5">
        <div class="container">
            @if (Session::has('success'))
                <div class="col-md-12 p-0">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            @if (Session::has('error'))
                <div class="col-md-12 p-0">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            <div class="login-form p-0">    
                <form action="{{ route('front.authenticate') }}" method="post">
                    @csrf
                    <h4 class="modal-title">Login to Your Account</h4>
                    <div class="profile-form-group">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="profile-form-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password">
                        @error('password')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="profile-form-group small">
                        <a href="{{ route('account.forgotPassword') }}" class="forgot-link">Forgot Password?</a>
                    </div> 
                    <input type="submit" class="btn btn-dark btn-block btn-lg profile-btn" value="Login">              
                </form>			
                <div class="signup-link text-center small mt-3">Don't have an account? <a href="{{ route('front.register') }}">Sign up</a></div>
            </div>
        </div>
    </section>
 </div>
 @endsection
 