{{-- resources/views/employee-board.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Employee Board</h2>
    <div class="row">
        @foreach($users as $user)
            <div class="col-md-4 mb-4">
                <div class="card shadow-lg border-0 rounded">
                    <div class="card-header" style="background-color: rgba(0,113,190,0.2); color: black; text-align: center;">
                        <h5 class="mb-0">{{ $user->firstName }} {{ $user->lastName }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <strong>Phone:</strong>
                            <a href="tel:{{ $user->phone }}" class="text-decoration-none">{{ $user->phone }}</a><br>
                            <strong>Email:</strong>
                            <a href="mailto:{{ $user->email }}" class="text-decoration-none">{{ $user->email }}</a>
                        </p>
                    </div>
                    <div class="card-footer text-center">
                        @if(auth()->user()->super_admin)
                            <a href="/admin/resources/users/{{ $user->id }}" class="btn btn-outline-primary btn-sm">View
                                                                                                                    Profile</a>@else
                            <button class="btn btn-outline-primary btn-sm" disabled>View Profile</button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center">
        {{ $users->links() }}
    </div>
</div>

@endsection
