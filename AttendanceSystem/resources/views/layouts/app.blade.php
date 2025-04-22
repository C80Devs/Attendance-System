@include('partials.header')


<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col">

            <h4 class="text-center fw-bold text-muted">{{$settings->name ?? config('app.name')}} </h4>
            @yield('content')
        </div>
    </div>
</div>


<footer>
    @include('partials.footer')
</footer>
