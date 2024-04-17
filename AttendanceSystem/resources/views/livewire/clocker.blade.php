
<div class="row">
    <div class="flex justify-center">
        <div>
            <div class="col">
                @if (session()->has('error'))
                    <p class="alert alert-danger px-4 mx-auto text-center">{{ session('error') }}</p>
                @endif
            </div>
        </div>
    </div>


    <div class="col">


        <div class="card border-light text-center">
            <div class="card-header">
                Current Time
            </div>
            <div class="card-body ">
                <h1 id="current-time"></h1>
                @if($clockedIn)
                    <button id="clock-button" wire:click="clock(latitude, longitude)" class="btn btn-danger mb-4"><i
                            class="bi bi-clock text-center"></i>
                        Clock Out
                    </button>

                    <p class="alert-success text-muted pt-2 pb-4 text-center"><i class="bi bi-clock"></i> You clocked in
                        at {{$clockInTime}}!</p>

                @elseif($clockedOut)
                    <p class="text-muted text-center"><i class="bi bi-clock"></i> Done, check back tomorrow!</p>
                    <p class="alert-warning text-muted pt-2 pb-4 text-center"><i class="bi bi-clock"></i> You clocked
                        out at {{$clockOutTime}}!</p>

                @else
                    <button id="clock-button" wire:click="clock(latitude, longitude)" class="btn primaryButton"><i
                            class="bi bi-clock text-center"></i>
                        Clock In
                    </button>
                @endif

                <div id="location_alert" class="alert alert-warning mt-4 text-center" style="display: none;">Turn on
                    location.
                </div>
            </div>


            <div class="card-footer text-muted mt-0 mb-2">
                <div class="row align-items-center">
                    <div class="row mb-2">
                        <i class="material-icons">location_on</i>
                    </div>
                    <div class="row text-center">
                        <p>                       {{ now()->timezoneName }}
                        </p>
                        <div wire:ignore>
                            @if ($location)
                                <div id="map" style="height: 300px; width: 100%"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


</div>


<script>
    let latitude;
    let longitude;
    let mapInitialized = false;

    // Function to initialize Leaflet map
    function initializeMap() {
        if (!mapInitialized && latitude !== undefined && longitude !== undefined) {
            var map = L.map('map', {
                center: [latitude, longitude],
                zoom: 30, // Zoom level adjusted for street level
                zoomControl: false, // Disable zoom control
                draggable: false, // Disable map dragging
                doubleClickZoom: false, // Disable double-click zoom
                scrollWheelZoom: false, // Disable scroll wheel zoom
                boxZoom: false, // Disable box zoom
                keyboard: false // Disable keyboard navigation
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([latitude, longitude]).addTo(map)
                .bindPopup('Clock-in Location')
                .openPopup();

            mapInitialized = true;
        }
    }

    let location_alert = document.getElementById("location_alert");
    let locationRetrieved = false;

    let clock_button = document.getElementById("clock-button");
    setInterval(updateTime, 1000);
    let locationInterval = setInterval(getLocationAndClock, 1000);

    function getLocationAndClock() {
        if (locationRetrieved) {
            clearInterval(locationInterval);
        }
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                locationRetrieved = true;
                latitude = position.coords.latitude;
                longitude = position.coords.longitude;
                enableClockButton();
                // Call initializeMap function after latitude and longitude are set
                initializeMap();
            }, function (error) {
                console.error('Error getting location:', error);
                location_alert.style.display = 'block';
                location_alert.innerText = 'Error: Unable to turn on location.';
                disableClockButton();
            });
        } else {
            console.error('Geolocation is not supported by this browser.');
            disableClockButton();
        }
    }

    function updateTime() {
        var currentTime = new Date().toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            hour12: true
        });

        document.getElementById('current-time').innerHTML = '<strong>' + currentTime + '</strong>';
    }

    updateTime();
    setInterval(updateTime, 1000);

    function disableClockButton() {
        clock_button.style.display = 'none';
        location_alert.style.display = 'block';
    }

    function enableClockButton() {
        clock_button.style.display = 'inline';
        location_alert.style.display = 'none';
    }

    Livewire.on('mapRefresh', () => {
        initializeMap();
    });
</script>
</script>
