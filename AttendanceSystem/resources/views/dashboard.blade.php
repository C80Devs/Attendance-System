@php use App\Models\SettingsModel; @endphp
@extends('layouts.app')
@section('content')
    <div class="mb-4">

        @php
            $settings = SettingsModel::first()
        @endphp
        <h4 class="text-center fw-bold text-muted">{{$settings->name ?? config('app.name')}} </h4>
        @if (is_null(Auth::user()->date_of_birth))
            <div class="alert text-center">
                <p>Please update your birthday. <a href="{{ route('profile') }}">Go to Profile</a></p>
            </div>
        @endif

        <div class="row py-0 my-0">
            <div class="col">
                <livewire:Clocker/>
            </div>
        </div>

        <!-- Bell Icon for Announcements -->
        @if($announcements->isNotEmpty())
        <div class="position-fixed" style="top: 20px; right: 20px; z-index: 1050; cursor: pointer;" onclick="toggleAnnouncementCard()">
            <i class="fas fa-bell fs-4 text-dark" ></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $announcements->count() }}
            </span>
        </div>
        @endif

        <!-- Announcement Overlay Card -->
        @if($announcements->isNotEmpty())
        <div class="overlay-announcement-card" onclick="hideAnnouncementCard()" style="display: block;">
            <div class="card shadow-lg p-4 position-fixed" style="top: 60px; right: 20px; max-width: 400px; max-height: 80vh;">
                <div class="card-header bg-light text-black">
                    <h5>Announcements</h5>
                    <button type="button" class="close" onclick="hideAnnouncementCard()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body" style="overflow-y: auto; max-height:100%;">
                    @foreach($announcements as $announcement)
                        <div class="announcement-item mb-3 p-3 rounded {{ $announcement->isActive() ? 'bg-secondary bg-opacity-10' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <p class="mb-2">{{ $announcement->message }}</p>
                                @if($announcement->isActive())
                                    <span style="background-color: rgb(145, 234, 204)"  class="badge text-dark">Active</span>
                                @endif
                            </div>
                            <small class="text-muted">Posted: {{ $announcement->created_at->format('jS M Y, h:i A') }}</small> <br>

                            <small class="text-muted">Expires: {{ $announcement->expires_at->format('jS M Y, h:i A') }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
      @endif

        @include('partials.highlights')
        @include('partials.birthday')
      


        <script>
            function hideAnnouncementCard() {
                document.querySelector('.overlay-announcement-card').style.display = 'none';
            }

            function toggleAnnouncementCard() {
                const card = document.querySelector('.overlay-announcement-card');
                card.style.display = card.style.display === 'none' ? 'block' : 'none';
            }
        </script>
    </div>

@endsection
