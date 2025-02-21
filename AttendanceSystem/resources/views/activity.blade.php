@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- Adjusted column width for better layout -->
            @if ($attendance->isEmpty())
                <div class="alert alert-secondary text-center" role="alert">
                    No Attendance record found!
                </div>
            @else
                <div class="card shadow-sm border-light">
                    <div class="card-header bg-light text-center">
                        <h5 class="mb-0">Attendance Activity ({{ $count }})</h5>
                    </div>
                    <div class="card-body">
                        @foreach($attendance as $attend)
                            <div class="mb-4"> <!-- Individual attendance record -->
                                <p class="text-muted mb-2">{{ $attend->clockInHeader }}</p>
                                <div class="card bg-light border-0 text-muted justify-content-center pb-3 pt-3">
                                    <div class="row align-items-center">
                                        <div class="col-4 text-center">
                                            <i class="material-icons text-success">schedule</i>
                                            <div class="row align-items-center d-flex">
                                                <a style="font-size: 10px" class="align-items-center"
                                                   href="{{ $attend->clockin_location }}">
                                                    View Clock In Location
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <strong>Clock In</strong>
                                        </div>
                                        <div class="col-4 text-center">
                                            <span>
                                                {{ $attend->clockInFormatted }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card bg-light border-0 text-muted justify-content-center mt-3 mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-4 text-center">
                                            <i class="material-icons text-danger">schedule</i>
                                            <div class="row align-items-center d-flex">
                                                <a style="font-size: 10px" class="align-items-center"
                                                   href="{{ $attend->clockout_location }}">
                                                    View Clock Out Location
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <strong>Clock Out</strong>
                                        </div>
                                        <div class="col-4 text-center">
                                            <span>
                                                {{ $attend->clockOutFormatted }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mb-2">
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer text-muted text-center">
                        <!-- Pagination Links -->
                        {{ $attendance->links('vendor.tailwind') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
