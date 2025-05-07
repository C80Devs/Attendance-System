@php use App\Models\VotesModel; use Carbon\Carbon; @endphp

<div class="mb-4">
    <!-- Active Polls Section -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Active Polls</h2>
        @if(!$activePolls->isEmpty())
            <span class="text-xs font-medium px-2 py-1 bg-primary/10 text-primary rounded-full">{{ $activePolls->total() }} {{ Str::plural('Poll', $activePolls->total()) }}</span>
        @endif
    </div>

    @if($activePolls->isEmpty())
        <div class="bg-gray-50 rounded-xl p-8 text-center shadow-sm mb-8">
            <div class="w-16 h-16 mx-auto bg-gray-200 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-700 mb-1">No Active Polls</h3>
            <p class="text-gray-500">There are no active polls at the moment. Check back later!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($activePolls as $poll)
                <div class="bg-white rounded-xl shadow-card hover:shadow-card-hover transition-all overflow-hidden">
                    <!-- Poll Header -->
                    <div class="p-5 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-800 text-center">{{ $poll->title }}</h3>
                    </div>

                    <!-- Poll Content -->
                    <div class="p-5">
                        <p class="text-gray-600 mb-4">{{ $poll->description }}</p>

                        <form wire:submit.prevent="vote({{ $poll->id }})">
                            <div class="space-y-4 mb-5">
                                @foreach($poll->options as $option)
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input
                                                type="radio"
                                                id="option{{ $option->id }}"
                                                name="selectedOptions[{{ $poll->id }}]"
                                                value="{{ $option->id }}"
                                                wire:model="selectedOptions.{{ $poll->id }}"
                                                required
                                                class="w-4 h-4 text-primary border-gray-300 focus:ring-primary"
                                            >
                                            <label for="option{{ $option->id }}" class="ml-2 text-sm font-medium text-gray-700">
                                                {{ $option->option }}
                                            </label>
                                        </div>

                                        @php
                                            $totalVotes = $poll->options->sum(function ($option) {
                                                return VotesModel::where('poll_option_id', $option->id)->count();
                                            });
                                            $optionVotes = VotesModel::where('poll_option_id', $option->id)->count();
                                            $percentage = $totalVotes ? ($optionVotes / $totalVotes) * 100 : 0;
                                        @endphp

                                        <div class="w-full bg-gray-200 rounded-full h-5 overflow-hidden">
                                            <div
                                                class="bg-primary h-5 rounded-full flex items-center justify-center text-xs text-white font-medium transition-all duration-500"
                                                style="width: {{ $percentage }}%"
                                            >
                                                @if($percentage > 10)
                                                    {{ $optionVotes }} {{ Str::plural('Vote', $optionVotes) }} ({{ number_format($percentage, 1) }}%)
                                                @endif
                                            </div>
                                        </div>
                                        @if($percentage <= 10 && $optionVotes > 0)
                                            <p class="text-xs text-gray-500 mt-1">{{ $optionVotes }} {{ Str::plural('Vote', $optionVotes) }} ({{ number_format($percentage, 1) }}%)</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <button
                                type="submit"
                                class="w-full px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50"
                            >
                                Submit Vote
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mb-8">
            {{ $activePolls->links() }}
        </div>
    @endif

    <!-- Closed Polls Section -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Closed Polls</h2>
        @if(!$closedPolls->isEmpty())
            <span class="text-xs font-medium px-2 py-1 bg-gray-200 text-gray-700 rounded-full">{{ $closedPolls->total() }} {{ Str::plural('Poll', $closedPolls->total()) }}</span>
        @endif
    </div>

    @if($closedPolls->isEmpty())
        <div class="bg-gray-50 rounded-xl p-8 text-center shadow-sm">
            <div class="w-16 h-16 mx-auto bg-gray-200 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-700 mb-1">No Closed Polls</h3>
            <p class="text-gray-500">There are no closed polls yet. Active polls will appear here once they expire.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($closedPolls as $poll)
                <div class="bg-white rounded-xl shadow-card hover:shadow-card-hover transition-all overflow-hidden">
                    <!-- Poll Header -->
                    <div class="p-5 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-800 text-center">{{ $poll->title }}</h3>
                    </div>

                    <!-- Poll Results -->
                    <div class="p-5">
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

                            $totalPollVotes = $voteCounts->sum('total_votes');
                        @endphp

                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 mr-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700">{{ $totalPollVotes }} {{ Str::plural('Vote', $totalPollVotes) }}</span>
                            </div>

                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 mr-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700">Ended {{ Carbon::parse($poll->expired_at)->format('M j, Y') }}</span>
                            </div>
                        </div>

                        <h4 class="text-sm font-medium text-gray-700 mb-3">Results:</h4>

                        @if($winningOptions->isNotEmpty())
                            <div class="space-y-3">
                                @foreach($poll->options as $option)
                                    @php
                                        $optionVotes = isset($voteCounts[$option->id]) ? $voteCounts[$option->id]->total_votes : 0;
                                        $percentage = $totalPollVotes ? ($optionVotes / $totalPollVotes) * 100 : 0;
                                        $isWinner = $winningOptions->has($option->id);
                                    @endphp

                                    <div class="space-y-1">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                @if($isWinner && $optionVotes > 0)
                                                    <svg class="w-4 h-4 text-success mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @endif
                                                <span class="text-sm {{ $isWinner && $optionVotes > 0 ? 'font-medium text-success' : 'text-gray-700' }}">
                                                    {{ $option->option }}
                                                </span>
                                            </div>
                                            <span class="text-xs text-gray-500">
                                                {{ $optionVotes }} {{ Str::plural('vote', $optionVotes) }}
                                            </span>
                                        </div>

                                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                            <div
                                                class="{{ $isWinner && $optionVotes > 0 ? 'bg-success' : 'bg-gray-400' }} h-2 rounded-full transition-all duration-500"
                                                style="width: {{ $percentage }}%"
                                            ></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-lg p-4 text-center">
                                <p class="text-sm text-gray-500">No votes were cast for this poll</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-6">
            {{ $closedPolls->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>
