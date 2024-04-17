@include('partials.header')
<body>
<div class="app horizontal-menu app-auth-sign-up align-content-stretch d-flex flex-wrap justify-content-end">
    <div class="app-auth-background"></div>
    <div class="app-auth-container ">
        <div class="logo">
            <a href="{{route('dashboard')}}">{{env('APP_NAME')}}</a>
        </div>
        <p class="auth-description">Please enter your credentials to create an account.<br>Already have an account? <a
                href="{{route('login')}}">Sign In</a></p>

        <form action="{{ route('register') }}" method="POST">
            @csrf <!-- CSRF Protection -->



            <div class="auth-credentials m-b">
                <div class="row">
                    <div class="col-md-6">
                        <label for="firstName" class="form-label">First Name</label>
                        <input required type="text" class="form-control m-b-md" id="firstName" name="firstName"
                               aria-describedby="firstName" placeholder="Enter first name">
                    </div>
                    <div class="col-md-6">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input required type="text" class="form-control m-b-md" id="lastName" name="lastName"
                               aria-describedby="lastName" placeholder="Enter last name">
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email address</label>
                        <input requiredtype="email" class="form-control m-b-md" id="email" name="email"
                               aria-describedby="email" placeholder="example@c80.com">
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input required type="text" class="form-control m-b-md" id="phone" name="phone"
                               aria-describedby="phone" placeholder="09012345678">
                    </div>
                </div>
<div class="row">
    <div class="col-md-6">
        <label for="password" class="form-label">Password</label>
        <input required type="password" class="form-control m-b-md" id="password" name="password"
               aria-describedby="password"
               placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
    </div>

    <div class="col-md-6">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input required type="password" class="form-control" id="password_confirmation" name="password_confirmation"
               aria-describedby="password_confirmation" placeholder="Confirm password">
    </div>
</div>



            </div>

            <div class="auth-submit mt-2">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="submit" class="btn primaryButton mt-2">Sign Up</button>
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
