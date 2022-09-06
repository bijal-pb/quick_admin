@include('layouts.admin.loginHeader')
<div class="page-wrapper auth">
    <div class="page-inner bg-brand-gradient">
        <div class="page-content-wrapper bg-transparent m-0">
            <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                <div class="d-flex align-items-center container p-0">
                    <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 border-0">
                        <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                            <img src="{{ URL::asset('admin_assets/img/logo.png')}}" alt="SmartAdmin WebApp" aria-roledescription="logo">
                            <span class="page-logo-text mr-1">Smoke Cellar</span>
                        </a>
                    </div>
                    {{-- <a href="page_register.html" class="btn-link text-white ml-auto">
                        Create Account
                    </a> --}}
                </div>
            </div>
            
            <div class="flex-1" style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                    <div class="row">
                        <div class="col col-md-6 col-lg-7 hidden-sm-down">
                            <img src="{{ URL::asset('admin_assets/img/logo.png')}}" width="250" style="padding-top:80px;" alt="Smoke Cellar" aria-roledescription="logo">                            
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 ml-auto">
                            <h1 class="fw-400 mb-3 d-sm-block">
                                Login
                            </h1>
                            @if(Session::has('error'))
                                <div class="alert alert-danger">
                                {{ Session::get('error')}}
                                </div>
                            @endif
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                            <div class="card p-4 rounded-plus bg-faded">
                                <form id="js-login" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label" for="username">Email</label>
                                        <input type="email" id="username" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @if($errors->has('email'))
                                            <span class="help">{{$errors->first('email') }}</span>
                                        @endif
                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="password">Password</label>
                                        <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group text-left">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="rememberme">
                                            <label class="custom-control-label" for="rememberme"> Remember me for the next 30 days</label>
                                        </div>
                                    </div> --}}
                                    <div class="row no-gutters">
                                        {{-- <div class="col-lg-6 pr-lg-1 my-2">
                                            <button type="submit" class="btn btn-info btn-block btn-lg">Sign in with <i class="fab fa-google"></i></button>
                                        </div> --}}
                                        <div class="col-lg-6 pl-lg-1 my-2">
                                            <button type="submit" class="btn btn-danger btn-block btn-lg">Secure login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                        {{ now()->year }} © Smoke Cellar
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>