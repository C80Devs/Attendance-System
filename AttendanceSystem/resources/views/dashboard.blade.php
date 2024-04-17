@include('partials.header')

@livewire('header-calendar')

    <div class="row mt-4">
        <div class="col">
            <div id="location-prompt" class="alert alert-warning" style="display: none;">
                Please enable location services to use the clock feature.
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <livewire:Clocker/>
        </div>
    </div>

@include('partials.footer')
