    <div class="row mt-4">
        <div class="col">
            <div class="d-flex">
                @php
                    $currentDate = now()->startOfDay();
                @endphp
                @for ($i = 0; $i < 6; $i++)
                    @php
                        $date = $currentDate->copy()->addDays($i);
                        $isToday = $date->isToday();
                    @endphp
                    <div class="card {{ $isToday ? 'bgPrimary ' : '' }} m-2" style="width: calc(100% / 6);">
                        <div class="card-body p-2 hover-overlay">
                            <p class="card-subtitle text-center pt-2 {{ $isToday ? 'text-white ' : 'text-muted' }}">{{ $date->format('D') }}</p>
                            <h6 class="card-subtitle mb-2 {{ $isToday ? 'text-white ' : 'text-muted' }} text-center">{{ $date->format('d') }}</h6>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

