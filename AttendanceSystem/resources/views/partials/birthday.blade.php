<div class="container">
    <hr>
    <p class="text-left mb-4 mt-0 text-muted">Birthdays for {{date('M')}}.</p>
    <hr>

    <div id="animation" style="width: 300px; height: 300px; margin: 0 auto; display: none;"></div>

    <div class="row justify-content-center">
        @forelse ($upcomingBirthdays as $user)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm
            @if(Carbon\Carbon::parse($user->date_of_birth)->isToday())
                bg-warning text-white
            @else
                bg-light
            @endif">
                    <div class="card-body text-center py-4">
                        <h5 class="mb-2">
                            {{ $user->firstName }}
                            @if(Carbon\Carbon::parse($user->date_of_birth)->isToday())
                                <span class="badge bg-success ml-2">Today!</span>
                                <i class="fas fa-birthday-cake ml-1" title="Happy Birthday!"></i>
                            @endif
                        </h5>
                        <p class="card-text mb-2 text-muted">
                            Birthday: {{ \Carbon\Carbon::parse($user->date_of_birth)->format('F j') }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light text-center py-5">
                    <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                    <p class="mb-0">No birthdays this month!</p>
                </div>
            </div>
        @endforelse
    </div>


</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.6/lottie.min.js"></script>
<script>
    const hasBirthdayToday = @json($upcomingBirthdays->contains(function($user) {
        return Carbon\Carbon::parse($user->date_of_birth)->isToday();
    }));

    window.addEventListener("load", () => {
        if (hasBirthdayToday) {
            const animationContainer = document.getElementById('animation');
            animationContainer.style.display = 'block';

            playBirthdayAnimation('animation');
        }
    });

    function playBirthdayAnimation(containerId) {
        const animationContainer = document.getElementById(containerId);

        const animation = lottie.loadAnimation({
            container: animationContainer,
            renderer: 'svg',
            loop: false,
            autoplay: true,
            path: '{{ asset("assets/ballons.json") }}'
        });

        animation.addEventListener('complete', function () {
            animationContainer.style.display = 'none';
        });
    }
</script>
