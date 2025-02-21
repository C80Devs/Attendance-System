<!-- Clocker Component -->
<div class="container mt-4 mb-0">
    <div class="row">
        <div class="col-12">
            <div class="card border-light text-center shadow-none">

                <div class="card-body">
                    <h1 id="current-time" class="display-4"></h1>
                    @if($clockedIn)
                        <button id="clock-button" wire:click="clock(latitude, longitude)" class="btn primaryButton ">
                            <i class="bi bi-clock"></i> Clock Out
                        </button>
                        <div style="background-color: #F7F7F7; color: black" class="mt-4 mb-2 alert alert-muted">
                            <i class="fas fa-info-circle me-2"></i>
                             Clocked in at {{ $clockInTime }}!
                        </div>
                    @elseif($clockedOut)
                        <p class="text-muted"><i class="bi bi-clock"></i> Done, check back tomorrow!</p>
                        <p class="text-muted pt-2 pb-4">
                            <i class="bi bi-clock"></i> You clocked out at {{ $clockOutTime }}!
                        </p>
                    @else
                        <button id="clock-button" wire:click="clock(latitude, longitude)" class="btn primaryButton">
                            <i class="bi bi-clock"></i> Clock In
                        </button>
                    @endif
                    <div id="location_alert" class="text-warning mt-4" style="display: none;">Turn on location.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let latitude;
    let longitude;
    let location_alert = document.getElementById("location_alert");
    let locationRetrieved = false;
    let clock_button = document.getElementById("clock-button");

    setInterval(updateTime, 1000);
    let locationInterval = setInterval(getLocationAndClock, 3000);

    function getLocationAndClock() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    latitude = position.coords.latitude;
                    longitude = position.coords.longitude;
                    locationRetrieved = true;
                    enableClockButton();
                    clearInterval(locationInterval);
                },
                function (error) {
                    console.error('Error getting location:', error);
                    showLocationError();
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } else {
            showLocationError('Error: Your browser does not support geolocation.');
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

    function showLocationError(message = 'Error: Unable to turn on location, retrying.') {
        location_alert.style.display = 'block';
        location_alert.innerText = message;
        disableClockButton();
    }

    function disableClockButton() {
        clock_button.style.display = 'none';
        location_alert.style.display = 'block';
    }

    function enableClockButton() {
        clock_button.style.display = 'inline';
        location_alert.style.display = 'none';
    }
</script>
