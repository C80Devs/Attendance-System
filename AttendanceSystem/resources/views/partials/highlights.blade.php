<div class="container">
    <p class="text-left mb-4 mt-0 text-muted">Highlights</p>
    <div class="row my-2 mx-2">
        <div class="col-12 bg-muted py-2 " style="background: #F7F7F7">
            <p class="text-sm">Attendance in {{ date('F') }}</p>
            <div class="row">
                <div class="col-3">
                    <h5 class="font-weight-bold text-sm" style="font-weight: bolder">{{$userAttendanceCount}}
                        /{{$numberOfWorkingDays}}</h5>
                </div>
                <div class="col-9 d-flex  align-items-center px-2">
                    <p class="px-2 mb-0 small text-danger text-sm">Late - {{$lateAttendance}}</p>
                    <p class="px-2 mb-0 small text-success text-sm">Early - {{$earlyAttendance}}</p>
                    <p style="color: #7bffd9" class="mb-0 bg-success px-2 rounded small text-sm">{{$earlyAttendancePercentage}}%</p>
                </div>
            </div>
        </div>
    </div>


    <div class="row my-2 mx-2">
        @if($settings->leave_active)

        <div class="col-12 bg-muted py-2 " style="background: #F7F7F7">
            <p class="text-sm">Leave Request Remaining</p>
            <div class="row">
                <div class="col-3">
                    <h5 class="font-weight-bold text-sm" style="font-weight: bolder">{{$remainingLeaveDays}}</h5>
                </div>

                <div class="col-9 d-flex justify-content-between align-items-center">
                    @if(!$topLeaveTypes->empty())
                    @foreach($topLeaveTypes as $leaveType)
                        <p class="mb-0 small text-sm">{{ $leaveType->type }} - {{ $leaveType->leave_count }}</p>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
            @endif
    </div>

    <div class="row my-2 mx-2">
        @if($settings->task_active)

        <div class="col-12 bg-muted py-2" style="background: #F7F7F7; border-radius: 8px;">
            <p class="text-sm mb-2">Task Management</p>
            <div class="row">
                <div class="col-3">
                    <h5 class="font-weight-bold" style="font-size: 1.3rem; font-weight: bolder">{{ $totalTasks }}</h5>
                </div>
                <div class="col-9 d-flex align-items-center">
                    <!-- Completed -->
                    <div class="px-2 d-flex align-items-center">
                        <p class="mb-0 small text-success"><i class="fas fa-check-circle text-success me-1"></i>
                            - {{ $completedTasks }}</p>
                    </div>
                    <!-- Ongoing -->
                    <div class="px-2 d-flex align-items-center">
                        <p class="mb-0 small text-warning"><i class="fas fa-spinner text-warning me-1"></i>
                            - {{ $ongoingTasks }}</p>
                    </div>
                    <!-- Failed -->
                    <div class="px-2 d-flex align-items-center">
                        <p class="mb-0 small text-danger"><i class="fas fa-times-circle text-danger me-1"></i>
                            - {{ $failedTasks }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
