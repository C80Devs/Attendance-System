@include('partials.header')
@livewire('header-calendar')

<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            @if ($attendance->isEmpty())
                <div class="alert alert-secondary text-center" role="alert">
                    No Attendance record found!
                </div>
            @else
                <div class="container-fluid">
                    <div class="row mt-4">
                        <div class="col">
                            <div class="card-title text-center text-muted">Attendance Activity ({{$count}})</div>
                            <hr class="text-muted mb-4">

                            @foreach($attendance as $attend)
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-muted mb-2">{{$attend->clockInHeader}}</p>
                                        <div class="card bg-white border-0 text-muted justify-content-center pb-4 pt-4"
                                             style="height: 60px">
                                            <div class="row align-items-center">
                                                <div class="col-4 text-center">
                                                    <i class="material-icons text-success">schedule</i>
                                                    <div class="row align-items-center d-flex">
                                                        <a style="font-size: 10px" class="align-items-center"
                                                           href="{{$attend->clockin_location}}">
                                                            View Location </a>

                                                    </div>
                                                </div>
                                                <div class="col-4 text-center">
                                                    Clock In
                                                </div>
                                                <div class="col-4 text-center">
                                                    {{$attend->clockIn}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card bg-white border-0 text-muted justify-content-center mt-4 mb-4"
                                             style="height: 60px">
                                            <div class="row align-items-center">
                                                <div class="col-4 text-center">
                                                    <i class="material-icons text-danger">schedule</i>
                                                    <div class="row align-items-center d-flex">
                                                        <a style="font-size: 10px" class="align-items-center"
                                                           href="{{$attend->clockin_location}}">
                                                            View Location </a>

                                                    </div>
                                                </div>
                                                <div class="col-4 text-center">
                                                    Clock Out
                                                </div>
                                                <div class="col-4 text-center">
                                                    {{$attend->clockOut}}
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mb-2">
                                    </div>
                                </div>
                            @endforeach

                            <!-- Tailwind Pagination Links -->
                            <div class="mt-4 flex justify-center">
                                {{ $attendance->links('vendor.tailwind') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@include('partials.footer')
