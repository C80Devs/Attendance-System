<?php

namespace App\Livewire;

use App\Models\PollModel;
use App\Models\VotesModel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Poll extends Component
{
    use WithPagination;

    public $selectedOptions = [];
    public $userVotes;
    public $perPage = 1; // Set number of polls to display per page

    public function mount ()
    {
        // Load user selections on mount
        $this->loadUserSelections();
    }

    public function loadUserSelections ()
    {
        $userVotes = VotesModel::where('user_id', auth()->id())->get();
        foreach ($userVotes as $vote) {
            $this->selectedOptions[$vote->poll_id] = $vote->poll_option_id;
        }
    }

    public function vote ($pollId)
    {
        $this->validate([
            'selectedOptions.' . $pollId => 'required|exists:poll_options,id',
        ]);

        DB::transaction(function() use ($pollId) {
            VotesModel::where('user_id', auth()->id())
                ->where('poll_id', $pollId)
                ->delete();

            VotesModel::create([
                'user_id' => auth()->id(),
                'poll_option_id' => $this->selectedOptions[$pollId],
                'poll_id' => $pollId,
            ]);
        });

        // Reset selected options after voting
        $this->selectedOptions[$pollId] = null;

        // Dispatch a success alert
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Thank you for voting!']);
    }

    public function render ()
    {
        $activePolls = PollModel::where('status', 'active')->with('options')->paginate($this->perPage);
        $closedPolls = PollModel::where('status', 'closed')->with('options')->paginate($this->perPage);

        return view('livewire.poll', [
            'activePolls' => $activePolls,
            'closedPolls' => $closedPolls,
            'userVotes' => $this->userVotes,
        ]);
    }
}
