@php use App\Models\VotesModel;use Carbon\Carbon; @endphp
<div class="container mt-4">
    <style>
        .list-group-item {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
            padding: 1rem;
        }

        .winner {
            color: green;
            font-weight: bold;
        }

        h2.h4 {
            margin-top: 20px;
        }

        /* Progress bar styling */
        .progress {
            height: 20px;
            border-radius: 5px;
        }
    </style>

    {{-- Active Polls Section --}}
    <h2 class="h4 text-center mt-4">Active Polls</h2>
    @if($activePolls->isEmpty())
        <p class="text-muted text-center">No active polls at the moment.</p>
    @else
        <div class="row mt-3">
            @foreach($activePolls as $poll)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header text-center">
                            <h5 class="card-title">{{ $poll->title }}</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $poll->description }}</p>
                            <form wire:submit.prevent="vote({{ $poll->id }})">
                                <div class="form-group">
                                    @foreach($poll->options as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                   name="selectedOptions[{{ $poll->id }}]"
                                                   value="{{ $option->id }}" id="option{{ $option->id }}"
                                                   wire:model="selectedOptions.{{ $poll->id }}" required>
                                            <label class="form-check-label" for="option{{ $option->id }}">
                                                {{ $option->option }}
                                            </label>

                                            @php
                                                $totalVotes = $poll->options->sum(function ($option) {
                                                    return VotesModel::where('poll_option_id', $option->id)->count();
                                                });
                                                $optionVotes = VotesModel::where('poll_option_id', $option->id)->count();
                                                $percentage = $totalVotes ? ($optionVotes / $totalVotes) * 100 : 0;
                                            @endphp

                                            <div class="progress mt-2">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: {{ $percentage }}%;"
                                                     aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    {{ $optionVotes }} Votes ({{ number_format($percentage, 2) }}%)
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Vote</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-3 custom-pagination">
                {{ $activePolls->links() }}
            </div>

        </div>
    @endif


    {{-- Closed Polls Section --}}
    <h2 class="h4 text-center mt-4">Closed Polls</h2>
    @if($closedPolls->isEmpty())
        <p class="text-muted text-center">No closed polls.</p>
    @else
        <div class="row mt-3">
            @foreach($closedPolls as $poll)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header text-center">
                            <h5 class="card-title">{{ $poll->title }}</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $voteCounts = VotesModel::select('poll_option_id', DB::raw('count(*) as total_votes'))
                                    ->where('poll_id', $poll->id)
                                    ->groupBy('poll_option_id')
                                    ->get()
                                    ->keyBy('poll_option_id');
                                $maxVotes = $voteCounts->max('total_votes');

                                $winningOptions = $voteCounts->filter(function($item) use ($maxVotes) {
                                    return $item->total_votes === $maxVotes;
                                });
                            @endphp

                            <h6>Total Votes: {{ $voteCounts->sum('total_votes') }}</h6>
                            <h6>Expired Date: {{ Carbon::parse($poll->expired_at)->format('F j, Y') }}</h6>

                            <h6 class="mt-3">Winning Option(s):</h6>
                            @if($winningOptions->isNotEmpty())
                                @foreach($winningOptions as $winningOption)
                                    @php
                                        $option = $poll->options->find($winningOption->poll_option_id);
                                    @endphp
                                    <div class="alert alert-success">
                                        {{ $option->option }} ({{ $winningOption->total_votes }} votes)
                                    </div>
                                @endforeach
                            @else
                                <span class="text-muted">No votes yet</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="mt-3">
                {{ $closedPolls->links('vendor.pagination.tailwind') }}
            </div>

        </div>
    @endif

</div>
