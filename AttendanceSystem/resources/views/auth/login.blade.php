@include('partials.header')
<body>
<div class="app horizontal-menu app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
    <div class="app-auth-background">

    </div>
    <div class="app-auth-container">
        <div class="logo">
            <a href="{{route('dashboard')}}">{{env('APP_NAME')}}</a>
        </div>


        <form class="mt-4" action="{{ route('login') }}" method="POST">
            @csrf <!-- CSRF Protection -->
            <div class="auth-credentials m-b-xxl">
                <label for="signInEmail" class="form-label">Email address</label>
                <input required type="email" class="form-control m-b-md" id="signInEmail" name="email"
                       aria-describedby="signInEmail" placeholder="example@c80.com">

                <label for="signInPassword" class="form-label">Password</label>
                <input required type="password" class="form-control" id="signInPassword" name="password"
                       aria-describedby="signInPassword"
                       placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">


            </div>
                <p class="auth-description">Please sign-in to your account and continue to the dashboard.<br>Don't have
                    an
                    account? <a href="{{ route('register') }}">Sign Up</a></p>

            <div class="mx-auto">
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="auth-submit">
                <button type="submit" class="btn primaryButton">Sign In</button>
                <a href="{{route('password.email')}}" class="auth-forgot-password float-end">Forgot password?</a>
            </div>
        </form>

        <div class="divider"></div>
        <div class="auth-alts">
            {{--    <a href="#" class="auth-alts-google"></a>
            <a href="#" class="auth-alts-facebook"></a>
            <a href="#" class="auth-alts-twitter"></a>--}}
        </div>
    </div>
</div>

</body>
